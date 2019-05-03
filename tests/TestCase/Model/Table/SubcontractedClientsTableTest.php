<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubcontractedClientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SubcontractedClientsTable Test Case
 */
class SubcontractedClientsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SubcontractedClientsTable
     */
    public $SubcontractedClients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.subcontracted_clients',
        'app.training_sites',
        'app.corporate_clients',
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
        $config = TableRegistry::getTableLocator()->exists('SubcontractedClients') ? [] : ['className' => SubcontractedClientsTable::class];
        $this->SubcontractedClients = TableRegistry::getTableLocator()->get('SubcontractedClients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SubcontractedClients);

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
