<?php


namespace Firesphere\CSPHeaders\Tests;

use Firesphere\CSPHeaders\Models\SRI;
use Firesphere\CSPHeaders\Tasks\SRIRefreshTask;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Input\ArrayInput;

class SRIRefreshTaskTest extends SapphireTest
{
    public function testClearSRI()
    {
        SRI::get()->removeAll();
        $this->assertEquals(0, SRI::get()->count());
        $sri = new SRI();
        $sri->File = 'readme.md';
        $sri->write();
        $this->assertEquals(1, SRI::get()->count());

        // Test that the task clears out all SRI from the database
        $task = new SRIRefreshTask();
        $task->run(new ArrayInput([]), PolyOutput::create(PolyOutput::FORMAT_ANSI));
        $this->assertEquals(0, SRI::get()->count());
    }
}
