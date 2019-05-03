<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseTypeQualificationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseTypeQualificationsTable Test Case
 */
class CourseTypeQualificationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseTypeQualificationsTable
     */
    public $CourseTypeQualifications;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_type_qualifications',
        'app.course_types',
        'app.qualifications'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CourseTypeQualifications') ? [] : ['className' => CourseTypeQualificationsTable::class];
        $this->CourseTypeQualifications = TableRegistry::getTableLocator()->get('CourseTypeQualifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseTypeQualifications);

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
