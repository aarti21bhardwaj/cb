<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\DashboardRefreshComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\DashboardRefreshComponent Test Case
 */
class DashboardRefreshComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\DashboardRefreshComponent
     */
    public $DashboardRefresh;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->DashboardRefresh = new DashboardRefreshComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DashboardRefresh);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
