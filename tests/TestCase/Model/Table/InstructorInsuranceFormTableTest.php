<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstructorInsuranceFormTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstructorInsuranceFormTable Test Case
 */
class InstructorInsuranceFormTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InstructorInsuranceFormTable
     */
    public $InstructorInsuranceForm;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.instructor_insurance_form',
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
        $config = TableRegistry::getTableLocator()->exists('InstructorInsuranceForm') ? [] : ['className' => InstructorInsuranceFormTable::class];
        $this->InstructorInsuranceForm = TableRegistry::getTableLocator()->get('InstructorInsuranceForm', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InstructorInsuranceForm);

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
