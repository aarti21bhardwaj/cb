<?php
namespace App\Test\TestCase\Shell;

use App\Shell\UpdateTenantSettingsShell;
use Cake\TestSuite\ConsoleIntegrationTestCase;

/**
 * App\Shell\UpdateTenantSettingsShell Test Case
 */
class UpdateTenantSettingsShellTest extends ConsoleIntegrationTestCase
{

    /**
     * ConsoleIo mock
     *
     * @var \Cake\Console\ConsoleIo|\PHPUnit_Framework_MockObject_MockObject
     */
    public $io;

    /**
     * Test subject
     *
     * @var \App\Shell\UpdateTenantSettingsShell
     */
    public $UpdateTenantSettings;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMockBuilder('Cake\Console\ConsoleIo')->getMock();
        $this->UpdateTenantSettings = new UpdateTenantSettingsShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UpdateTenantSettings);

        parent::tearDown();
    }

    /**
     * Test getOptionParser method
     *
     * @return void
     */
    public function testGetOptionParser()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
