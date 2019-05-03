<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstructorInsuranceFormsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstructorInsuranceFormsTable Test Case
 */
class InstructorInsuranceFormsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InstructorInsuranceFormsTable
     */
    public $InstructorInsuranceForms;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.instructor_insurance_forms',
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
        $config = TableRegistry::getTableLocator()->exists('InstructorInsuranceForms') ? [] : ['className' => InstructorInsuranceFormsTable::class];
        $this->InstructorInsuranceForms = TableRegistry::getTableLocator()->get('InstructorInsuranceForms', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InstructorInsuranceForms);

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
