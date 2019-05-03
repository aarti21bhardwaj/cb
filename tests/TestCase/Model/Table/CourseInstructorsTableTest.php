<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseInstructorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseInstructorsTable Test Case
 */
class CourseInstructorsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseInstructorsTable
     */
    public $CourseInstructors;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_instructors',
        'app.courses',
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
        $config = TableRegistry::getTableLocator()->exists('CourseInstructors') ? [] : ['className' => CourseInstructorsTable::class];
        $this->CourseInstructors = TableRegistry::getTableLocator()->get('CourseInstructors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseInstructors);

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
