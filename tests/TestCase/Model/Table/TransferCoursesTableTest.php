<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransferCoursesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransferCoursesTable Test Case
 */
class TransferCoursesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TransferCoursesTable
     */
    public $TransferCourses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.transfer_courses',
        'app.courses',
        'app.tenants',
        'app.assigning_tenants'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TransferCourses') ? [] : ['className' => TransferCoursesTable::class];
        $this->TransferCourses = TableRegistry::getTableLocator()->get('TransferCourses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TransferCourses);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
