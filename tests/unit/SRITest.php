<?php


namespace Firesphere\CSPHeaders\Tests;

use Firesphere\CSPHeaders\Models\SRI;
use Firesphere\CSPHeaders\Tasks\SRIRefreshTask;
use Firesphere\CSPHeaders\View\CSPBackend;
use SilverStripe\Control\Controller;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Security\DefaultAdminService;

class SRITest extends SapphireTest
{
    private static $expected = [
        'DELETE_SRI' =>
            [
                'name'     => 'Delete SRI',
                'category' => 'SRI permissions',
                'help'     => 'Permission required to delete existing SRI\'s.',
            ],
    ];

    public function testCan()
    {
        $this->assertTrue((new SRI())->canView(null)); // You can view in any state
        $this->assertFalse((new SRI())->canEdit(null));
        $this->assertFalse((new SRI())->canDelete(null));
        $this->assertFalse((new SRI())->canCreate(null));
        $admin = DefaultAdminService::create()->findOrCreateAdmin('admin', 'test');
        $this->assertTrue((new SRI())->canView($admin));
        $this->assertFalse((new SRI())->canEdit($admin));
        $this->assertTrue((new SRI())->canDelete($admin));
        $this->assertFalse((new SRI())->canCreate($admin));
    }

    public function testPermissions()
    {
        $this->assertEquals(self::$expected, (new SRI())->providePermissions());
    }

    public function testOnBeforeWrite()
    {
        /** @var SRI $sri */
        SRI::get()->removeAll();
        $sri = SRI::create();
        $sri->File = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js';
        $sri->onBeforeWrite();
        $hash = hash(CSPBackend::SHA384, file_get_contents('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'), true);
        $this->assertEquals('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', $sri->File);
        $this->assertEquals(base64_encode($hash), $sri->SRI);
    }

    public function testFindOrCreate()
    {
        /** @var SRI $sri */
        SRI::get()->removeAll();
        $sri = SRI::findOrCreate('/README.md');
        $hash = hash(CSPBackend::SHA384, file_get_contents('README.md'), true);

        $this->assertEquals(base64_encode($hash), $sri->SRI);
        $this->assertGreaterThan(0, $sri->ID);
    }

    public function testOnAfterBuild()
    {
        SRI::get()->removeAll();
        $sri = SRI::create();
        $sri->File = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js';
        $sri->write();
        $this->assertEquals(1, SRI::get()->count());
        $sriSingleton = singleton(SRI::class);
        $sriSingleton->config()->set('clear_sri_on_build', true);
        $sriSingleton->onAfterBuild();
        $this->assertEquals(0, SRI::get()->count());
    }
}
