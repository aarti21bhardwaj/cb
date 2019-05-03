<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\DashBoardComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\DashBoardComponent Test Case
 */
class DashBoardComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\DashBoardComponent
     */
    public $DashBoard;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->DashBoard = new DashBoardComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DashBoard);

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
