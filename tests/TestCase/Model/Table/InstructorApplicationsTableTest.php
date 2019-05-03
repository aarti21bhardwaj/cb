<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstructorApplicationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstructorApplicationsTable Test Case
 */
class InstructorApplicationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InstructorApplicationsTable
     */
    public $InstructorApplications;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.instructor_applications',
        'app.instructors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InstructorApplications') ? [] : ['className' => InstructorApplicationsTable::class];
        $this->InstructorApplications = TableRegistry::getTableLocator()->get('InstructorApplications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InstructorApplications);

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
