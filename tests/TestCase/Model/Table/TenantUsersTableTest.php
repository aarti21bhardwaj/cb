<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TenantUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TenantUsersTable Test Case
 */
class TenantUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TenantUsersTable
     */
    public $TenantUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tenant_users',
        'app.tenants',
        'app.roles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TenantUsers') ? [] : ['className' => TenantUsersTable::class];
        $this->TenantUsers = TableRegistry::getTableLocator()->get('TenantUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TenantUsers);

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
