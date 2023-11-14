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
 *
 * @package Firesphere\CSPHeaders
 *
 * This extension is applied to the PageController, to avoid duplicates.
 * Any duplicates may be caused by extended classes. It should however, not affect the outcome
 *
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
     * @var string[] YML keys to actual header name
     */
    protected static $policyKeyHeader = [
        'referrer'             => 'Referrer-Policy',
        'frame-options'        => 'X-Frame-Options',
        'content-type-options' => 'X-Content-Type-Options'
    ];
    /**
     * Should we generate the policy headers or not
     * @var bool
     */
    protected $addPolicyHeaders;
    /**
     * Should permission policies be added
     * @var bool
     */
    protected $addPermissionHeaders;
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
        if (self::$isTesting || !DB::is_active() || !ClassInfo::hasTable('Member') || Director::is_cli()) {
            return;
        }
        $config = CSPBackend::config();
        /** @var Controller $owner */
        $owner = $this->owner;
        $cspConfig = $config->get('csp_config');
        if ($this->owner instanceof LeftAndMain && !$cspConfig['in_cms']) {
            return;
        }

        $permissionConfig = $config->get('permissions_config');
        $this->addPolicyHeaders = ($cspConfig['enabled'] ?? false) || static::checkCookie($owner->getRequest());
        $this->addPermissionHeaders = $permissionConfig['enabled'] ?? false;
        /** @var Controller $owner */
        // Policy-headers
        if ($this->addPolicyHeaders) {
            $this->addCSPHeaders($cspConfig, $owner);
        }
        // Permission-policy
        if ($this->addPermissionHeaders) {
            $this->addPermissionsHeaders($permissionConfig, $owner);
        }
        // Access-Control-Allow-Origin
        $cors = $config->get('CORS');
        if ($cors && $cors['enabled']) {
            $responseHeaders = $this->createACMHeaders($cors, $owner);
            $this->addResponseHeaders($responseHeaders, $owner);
        }
        foreach (self::$policyKeyHeader as $key => $headerKey) {
            if ($value = $config->get($key)) {
                $this->addResponseHeaders([$headerKey => $value], $owner);
            }
        }
        // Strict-Transport-Security
        $hsts = $config->get('HSTS');
        if ($hsts['enabled']) {
            $header = $hsts['max-age'] ? sprintf('max-age=%s; ', $hsts['max-age']) : '0';
            $header .= $hsts['include_subdomains'] ? 'includeSubDomains' : '';
            $this->addResponseHeaders(['Strict-Transport-Security' => trim($header)], $owner);
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
     * Add the Permissions-Policy header
     * @param array $ymlConfig
     * @param Controller $controller
     * @return void
     */
    private function addPermissionsHeaders(mixed $ymlConfig, Controller $controller)
    {
        $config = Injector::inst()->convertServiceProperty($ymlConfig);
        $permissionHeaders = CSPBackend::config()->get('permission_headers');
        $policies = [];
        foreach ($config as $key => $value) {
            $key = strtolower($key);
            $policy = $permissionHeaders[$key] ?? false;

            if ($policy) {
                $policies[] = $this->ymlToPolicy($policy, $value);
            }
        }
        $headerAsArray = ['Permissions-Policy' => implode(', ', $policies)];

        $this->addResponseHeaders($headerAsArray, $controller);
    }

    private function ymlToPolicy($key, $yml)
    {
        $value = [];
        if (!empty($yml['self'])) {
            $value[] = "'self'";
        }
        if (!empty($yml['allow']) && !in_array('none', $yml['allow'])) {
            $value[] = implode(', ', $yml['allow']);
        }
        // If it's none, then anything else we did is useless
        if (in_array('none', $yml['allow'])) {
            $value = ["'none'"];
        }

        return sprintf('%s=(%s)', $key, implode(' ', $value));
    }

    /**
     * @return bool
     */
    public function isAddPolicyHeaders(): bool
    {
        return $this->addPolicyHeaders ?? false;
    }

    /**
     * Remove https://, trailing slash, etc.
     * @param $domain
     * @return string
     */
    private function trimDomain($domain)
    {
        $domain = explode('//', $domain);
        $domain = end($domain);
        [$domain] = explode('/', $domain);

        return $domain;
    }

    /**
     * @param mixed $cors
     * @param Controller $owner
     * @return array
     */
    protected function createACMHeaders(mixed $cors, Controller $owner): array
    {
        $responseHeaders = ['Access-Control-Allow-Methods' => implode(',', $cors['methods'])];
        if (in_array('*', $cors['allow'])) {
            $responseHeaders['Access-Control-Allow-Origin'] = '*';
        } else {
            $origin = (string)$owner->getRequest()->getHeader('origin');
            $base = Director::absoluteBaseURL();
            $trimmedOrigin = $this->trimDomain($origin);
            $trimmedBase = $this->trimDomain($base);
            $domains = explode(',', (string)Environment::getEnv('SS_ALLOWED_HOSTS'));
            $domains = array_merge($domains, $cors['allow'], [$trimmedBase]);

            if (in_array($trimmedOrigin, $domains)) {
                $allow = strlen($trimmedOrigin) ? $origin : $base;
                $responseHeaders['Access-Control-Allow-Origin'] = $allow;
            }
        }

        return $responseHeaders;
    }
}
