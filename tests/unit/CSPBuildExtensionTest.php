<?php

namespace Firesphere\CSPHeaders\Tests;

use Firesphere\CSPHeaders\Extensions\CSPBuildExtension;
use Firesphere\CSPHeaders\Models\SRI;
use Firesphere\CSPHeaders\View\CSPBackend;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\PolyExecution\PolyOutput;

class CSPBuildExtensionTest extends SapphireTest
{
    public function testOnAfterBuild()
    {
        CSPBackend::config()->set('clear_on_build', false);

        SRI::findOrCreate('/jstest.js');
        (new CSPBuildExtension())->onAfterBuild(PolyOutput::create(PolyOutput::FORMAT_ANSI), false, false);

        $this->assertEquals(1, SRI::get()->count());
        CSPBackend::config()->set('clear_on_build', true);
        (new CSPBuildExtension())->onAfterBuild(PolyOutput::create(PolyOutput::FORMAT_ANSI), false, false);
        $this->assertEquals(0, SRI::get()->count());
    }
}
