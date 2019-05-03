<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailRecipientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailRecipientsTable Test Case
 */
class EmailRecipientsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailRecipientsTable
     */
    public $EmailRecipients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.email_recipients',
        'app.emails',
        'app.corporate_clients',
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
        $config = TableRegistry::getTableLocator()->exists('EmailRecipients') ? [] : ['className' => EmailRecipientsTable::class];
        $this->EmailRecipients = TableRegistry::getTableLocator()->get('EmailRecipients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailRecipients);

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
