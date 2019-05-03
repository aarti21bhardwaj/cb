<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PromoCodeEmailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PromoCodeEmailsTable Test Case
 */
class PromoCodeEmailsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PromoCodeEmailsTable
     */
    public $PromoCodeEmails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.promo_code_emails',
        'app.promo_codes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PromoCodeEmails') ? [] : ['className' => PromoCodeEmailsTable::class];
        $this->PromoCodeEmails = TableRegistry::getTableLocator()->get('PromoCodeEmails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PromoCodeEmails);

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
