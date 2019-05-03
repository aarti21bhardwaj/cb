<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CorporateClientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CorporateClientsTable Test Case
 */
class CorporateClientsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CorporateClientsTable
     */
    public $CorporateClients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.corporate_clients',
        'app.urls',
        'app.tenants',
        'app.training_sites',
        'app.corporate_client_documents',
        'app.corporate_client_notes',
        'app.corporate_client_users',
        'app.courses',
        'app.locations',
        'app.promo_codes',
        'app.students',
        'app.subcontracted_clients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CorporateClients') ? [] : ['className' => CorporateClientsTable::class];
        $this->CorporateClients = TableRegistry::getTableLocator()->get('CorporateClients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CorporateClients);

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
