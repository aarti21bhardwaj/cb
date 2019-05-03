<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TenantResetPasswordHashesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TenantResetPasswordHashesTable Test Case
 */
class TenantResetPasswordHashesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TenantResetPasswordHashesTable
     */
    public $TenantResetPasswordHashes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tenant_reset_password_hashes',
        'app.tenant_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TenantResetPasswordHashes') ? [] : ['className' => TenantResetPasswordHashesTable::class];
        $this->TenantResetPasswordHashes = TableRegistry::getTableLocator()->get('TenantResetPasswordHashes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TenantResetPasswordHashes);

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
