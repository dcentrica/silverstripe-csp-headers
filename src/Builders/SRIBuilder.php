<?php

namespace Firesphere\CSPHeaders\Builders;

use Exception;
use Firesphere\CSPHeaders\Models\SRI;
use Firesphere\CSPHeaders\View\CSPBackend;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\Core\Validation\ValidationException;
use SilverStripe\Security\Permission;

/**
 * Class Firesphere\CSPHeaders\Builders\SRIBuilder
 *
 * @package Firesphere\CSPHeaders
 *
 */
class SRIBuilder
{
    use Configurable;

    /**
     * An array of javascript or css files to skip applying SRI to.
     * Files only need to start with the configured value, e.g. if this array contains
     * 'https://example.com' then all scripts from that site will be skipped.
     * @var array
     */
    private static $skip_domains = [];

    /**
     * List of the SRI's
     * @var ArrayList|SRI[]
     */
    private static $sri;

    /**
     * @param $file
     * @param array $htmlAttributes
     * @return array
     * @throws ValidationException
     * @throws Exception
     */
    public function buildSRI($file, array $htmlAttributes): array
    {
        $config = $this->config();
        if ($config->get('remote_only') && Director::is_site_url($file)) {
            return $htmlAttributes;
        }
        if (!self::$sri) {
            self::$sri = ArrayList::create(SRI::get()->toArray());
        }
        $skipFiles = $config->get('skip_domains') ?? [];
        foreach ($skipFiles as $filename) {
            if (strpos($file, $filename) === 0) {
                return $htmlAttributes;
            }
        }
        $sri = self::$sri->find('File', $file);
        if ($sri && $this->shouldUpdateSRI() && !empty($sri->SRI)) {
            // If an update is needed, set the SRI to null
            $sri->SRI = null;
            $sri->forceChange();
            $sri->write();
        }
        if (!$sri) {
            $sri = SRI::findOrCreate($file);
        }

        // To skip applying SRI for an environment use yml to disable jsSRI or cssSRI within chosen envs
        if ($sri->SRI) {
            $htmlAttributes['integrity'] = sprintf('%s-%s', CSPBackend::SHA384, $sri->SRI);
            $htmlAttributes['crossorigin'] = Director::is_site_url($file) ? '' : 'anonymous';
        }

        return $htmlAttributes;
    }

    /**
     * @return bool
     */
    private function shouldUpdateSRI(): bool
    {
        if (!$ctrl = Controller::curr()) {
            return false;
        }

        // Is updateSRI requested?
        return ($ctrl->getRequest()->getVar('updatesri') &&
            // Does the user have the powers
            (Permission::check('ADMIN', 'any') ||
                // OR the site is in dev mode
                Director::isDev()));
    }
}
