<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QualificationTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QualificationTypesTable Test Case
 */
class QualificationTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\QualificationTypesTable
     */
    public $QualificationTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.qualification_types',
        'app.instructor_qualifications'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('QualificationTypes') ? [] : ['className' => QualificationTypesTable::class];
        $this->QualificationTypes = TableRegistry::getTableLocator()->get('QualificationTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->QualificationTypes);

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
}
