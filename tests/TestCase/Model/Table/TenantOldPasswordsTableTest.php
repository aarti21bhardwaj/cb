<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TenantOldPasswordsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TenantOldPasswordsTable Test Case
 */
class TenantOldPasswordsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TenantOldPasswordsTable
     */
    public $TenantOldPasswords;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tenant_old_passwords',
        'app.tenants'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TenantOldPasswords') ? [] : ['className' => TenantOldPasswordsTable::class];
        $this->TenantOldPasswords = TableRegistry::getTableLocator()->get('TenantOldPasswords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TenantOldPasswords);

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
