<?php

namespace Firesphere\CSPHeaders\Extensions;

use Firesphere\CSPHeaders\View\CSPBackend;
use SilverStripe\Core\Extension;
use SilverStripe\Dev\Command\DbBuild;
use SilverStripe\ORM\DB;
use SilverStripe\PolyExecution\PolyOutput;

/**
 * Class \Firesphere\CSPHeaders\Extensions\CSPBuildExtension
 * Runs on dev/build to remove all known SRIs
 * @package Firesphere\CSPHeaders
 * @property DbBuild|CSPBuildExtension $owner
 */
class CSPBuildExtension extends Extension
{
    /**
     * Truncate the SRI table on build
     */
    public function onAfterBuild(PolyOutput $output, bool $populate, bool $testMode): void
    {
        $config = CSPBackend::config()->get('clear_on_build');
        if ($config) {
            DB::query('TRUNCATE `SRI`');
        }
    }
}
