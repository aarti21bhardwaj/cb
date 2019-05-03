<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseStudentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseStudentsTable Test Case
 */
class CourseStudentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseStudentsTable
     */
    public $CourseStudents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_students',
        'app.courses',
        'app.students'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CourseStudents') ? [] : ['className' => CourseStudentsTable::class];
        $this->CourseStudents = TableRegistry::getTableLocator()->get('CourseStudents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseStudents);

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
