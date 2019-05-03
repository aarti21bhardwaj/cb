<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstructorQualificationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstructorQualificationsTable Test Case
 */
class InstructorQualificationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InstructorQualificationsTable
     */
    public $InstructorQualifications;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.instructor_qualifications',
        'app.instructors',
        'app.qualifications',
        'app.qualification_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InstructorQualifications') ? [] : ['className' => InstructorQualificationsTable::class];
        $this->InstructorQualifications = TableRegistry::getTableLocator()->get('InstructorQualifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InstructorQualifications);

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
