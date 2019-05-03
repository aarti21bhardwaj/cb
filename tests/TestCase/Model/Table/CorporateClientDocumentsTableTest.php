<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CorporateClientDocumentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CorporateClientDocumentsTable Test Case
 */
class CorporateClientDocumentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CorporateClientDocumentsTable
     */
    public $CorporateClientDocuments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.corporate_client_documents',
        'app.corporate_clients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CorporateClientDocuments') ? [] : ['className' => CorporateClientDocumentsTable::class];
        $this->CorporateClientDocuments = TableRegistry::getTableLocator()->get('CorporateClientDocuments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CorporateClientDocuments);

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
