<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstructorReferencesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstructorReferencesTable Test Case
 */
class InstructorReferencesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InstructorReferencesTable
     */
    public $InstructorReferences;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.instructor_references',
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
        $config = TableRegistry::getTableLocator()->exists('InstructorReferences') ? [] : ['className' => InstructorReferencesTable::class];
        $this->InstructorReferences = TableRegistry::getTableLocator()->get('InstructorReferences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InstructorReferences);

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
