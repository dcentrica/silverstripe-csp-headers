<?php

namespace Firesphere\CSPHeaders\Extensions;

use Exception;
use Firesphere\CSPHeaders\Models\CSPDomain;
use Firesphere\CSPHeaders\View\CSPBackend;
use LeKoala\DebugBar\DebugBar;
use ParagonIE\ConstantTime\Base64;
use ParagonIE\CSPBuilder\CSPBuilder;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Cookie;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Environment;
use SilverStripe\Core\Extension;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DB;
use function hash;

/**
 * Class \Firesphere\CSPHeaders\Extensions\ControllerCSPExtension
 * @package Firesphere\CSPHeaders
 * @property Controller|ControllerCSPExtension $owner
 */
class ControllerCSPExtension extends Extension
{
    /**
     * @var bool Public setting to avoid certain unnecessary effects during testing
     */
    public static $isTesting = false;
    /**
     * Base CSP configuration
     * @config
     * @var array
     */
    protected static $csp_config;
    /**
     * @var array
     */
    protected static $inlineJS = [];
    /**
     * @var array
     */
    protected static $inlineCSS = [];
    /**
     * Should we generate the policy headers or not
     * @var bool
     */
    protected $addPolicyHeaders;
    /**
     * @var string randomised sha512 nonce for enabling scripts if you don't want to use validating of the full script
     */
    protected $nonce;

    /**
     * @param string $js
     */
    public static function addJS($js)
    {
        static::$inlineJS[] = $js;
    }

    /**
     * @param string $css
     */
    public static function addCSS($css)
    {
        static::$inlineCSS[] = $css;
    }

    /**
     * @return array
     */
    public static function getInlineJS()
    {
        return static::$inlineJS;
    }

    /**
     * @return array
     */
    public static function getInlineCSS()
    {
        return static::$inlineCSS;
    }

    /**
     * Add the needed headers from the database and config
     * @throws Exception
     */
    public function onBeforeInit(): void
    {
        if (!self::$isTesting && (!DB::is_active() || !ClassInfo::hasTable('Member') || Director::is_cli())) {
            return;
        }
        $config = CSPBackend::config();
        /** @var Controller $owner */
        $owner = $this->owner;
        $cspConfig = $config->get('csp_config');
        if ($this->owner instanceof LeftAndMain && !$cspConfig['in_cms']) {
            return;
        }

        $this->addPolicyHeaders = ($cspConfig['enabled'] ?? false) || static::checkCookie($owner->getRequest());
        /** @var Controller $owner */
        // Policy-headers
        if ($this->addPolicyHeaders) {
            $this->addCSPHeaders($cspConfig, $owner);
        }
        $otherHeaders = $config->get('headers');
        if ($otherHeaders) {
            foreach ($otherHeaders as $name => $value) {
                $this->addResponseHeaders([$name => trim($value)], $owner);
            }
        }
    }

    /**
     * @param HTTPRequest $request
     * @return bool
     */
    public static function checkCookie($request): bool
    {
        if ($request->getVar('build-headers')) {
            Cookie::set('buildHeaders', $request->getVar('build-headers'));
        }

        return (Cookie::get('buildHeaders') === 'true');
    }

    /**
     * @param mixed $ymlConfig
     * @param Controller|null $owner
     * @return void
     * @throws Exception
     */
    private function addCSPHeaders(mixed $ymlConfig, Controller|null $owner): void
    {
        /** @var array $config */
        $config = Injector::inst()->convertServiceProperty($ymlConfig);
        $legacy = $config['legacy'] ?? true;
        $unsafeCSSInline = $config['style-src']['unsafe-inline'] ?? false;
        $unsafeJsInline = $config['script-src']['unsafe-inline'] ?? false;
        if ($owner && class_exists('\Page') && method_exists($owner, 'data')) {
            $config['style-src']['unsafe-inline'] = $unsafeCSSInline || $owner->data()->AllowCSSInline;
            $config['script-src']['unsafe-inline'] = $unsafeJsInline || $owner->data()->AllowJSInline;
        }

        $policy = CSPBuilder::fromArray($config);
        $endpoints = CSPBackend::config()->get('report-to') ?? [];

        foreach ($endpoints as $endpoint) {
            $policy->addReportEndpoints($endpoint);
        }

        $this->addCSP($policy, $owner);
        $this->addInlineJSPolicy($policy, $config);
        $this->addInlineCSSPolicy($policy, $config);
        // When in dev, add the debugbar nonce, requires a change to the lib
        if (Director::isDev() && class_exists('LeKoala\DebugBar\DebugBar')) {
            $bar = DebugBar::getDebugBar();

            if ($bar) {
                $bar->getJavascriptRenderer()->setCspNonce('debugbar');
                $policy->nonce('script-src', 'debugbar');
            }
        }

        $headers = $policy->getHeaderArray($legacy);
        $this->addResponseHeaders($headers, $owner);
    }

    /**
     * @param CSPBuilder $policy
     * @param Controller $owner
     */
    protected function addCSP($policy, $owner): void
    {
        /** @var DataList|CSPDomain[] $cspDomains */
        $cspDomains = CSPDomain::get();
        if (class_exists('\Page')) {
            $cspDomains = $cspDomains->filterAny(['Pages.ID' => [null, $owner->ID]]);
        }
        foreach ($cspDomains as $domain) {
            $policy->addSource($domain->Source, $domain->Domain);
        }
    }

    /**
     * @param CSPBuilder $policy
     * @param array $config
     * @throws Exception
     */
    protected function addInlineJSPolicy($policy, $config): void
    {
        if ($config['script-src']['unsafe-inline']) {
            return;
        }

        if (CSPBackend::config()->get('useNonce')) {
            $policy->nonce('script-src', $this->getNonce());
        }

        $inline = static::$inlineJS;
        foreach ($inline as $item) {
            $policy->hash('script-src', "//<![CDATA[\n{$item}\n//]]>");
        }
    }

    /**
     * @return null|string
     */
    public function getNonce()
    {
        if (!$this->nonce) {
            $this->nonce = Base64::encode(hash('sha512', uniqid('nonce', false)));
        }

        return $this->nonce;
    }

    /**
     * @param CSPBuilder $policy
     * @param array $config
     * @throws Exception
     */
    protected function addInlineCSSPolicy($policy, $config): void
    {
        if ($config['style-src']['unsafe-inline']) {
            return;
        }

        if (CSPBackend::config()->get('useNonce')) {
            $policy->nonce('style-src', $this->getNonce());
        }

        $inline = static::$inlineCSS;
        foreach ($inline as $css) {
            $policy->hash('style-src', "\n{$css}\n");
        }
    }

    /**
     * @param array $headers
     * @param Controller $owner
     */
    protected function addResponseHeaders(array $headers, Controller $owner): void
    {
        $response = $owner->getResponse();
        foreach ($headers as $name => $header) {
            if (!$response->getHeader($header)) {
                $response->addHeader($name, $header);
            }
        }
    }

    /**
     * @return bool
     */
    public function isAddPolicyHeaders(): bool
    {
        return $this->addPolicyHeaders ?? false;
    }
}
