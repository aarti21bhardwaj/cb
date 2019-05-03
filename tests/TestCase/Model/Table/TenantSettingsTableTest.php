<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TenantSettingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TenantSettingsTable Test Case
 */
class TenantSettingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TenantSettingsTable
     */
    public $TenantSettings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tenant_settings',
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
        $config = TableRegistry::getTableLocator()->exists('TenantSettings') ? [] : ['className' => TenantSettingsTable::class];
        $this->TenantSettings = TableRegistry::getTableLocator()->get('TenantSettings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TenantSettings);

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
