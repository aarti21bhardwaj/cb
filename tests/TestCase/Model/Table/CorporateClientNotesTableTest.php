<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CorporateClientNotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CorporateClientNotesTable Test Case
 */
class CorporateClientNotesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CorporateClientNotesTable
     */
    public $CorporateClientNotes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.corporate_client_notes',
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
        $config = TableRegistry::getTableLocator()->exists('CorporateClientNotes') ? [] : ['className' => CorporateClientNotesTable::class];
        $this->CorporateClientNotes = TableRegistry::getTableLocator()->get('CorporateClientNotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CorporateClientNotes);

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
