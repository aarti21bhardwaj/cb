<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailCourseTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailCourseTypesTable Test Case
 */
class EmailCourseTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailCourseTypesTable
     */
    public $EmailCourseTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.email_course_types',
        'app.emails',
        'app.course_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailCourseTypes') ? [] : ['className' => EmailCourseTypesTable::class];
        $this->EmailCourseTypes = TableRegistry::getTableLocator()->get('EmailCourseTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailCourseTypes);

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
