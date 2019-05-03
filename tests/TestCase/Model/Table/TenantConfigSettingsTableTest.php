<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TenantConfigSettingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TenantConfigSettingsTable Test Case
 */
class TenantConfigSettingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TenantConfigSettingsTable
     */
    public $TenantConfigSettings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tenant_config_settings',
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
        $config = TableRegistry::getTableLocator()->exists('TenantConfigSettings') ? [] : ['className' => TenantConfigSettingsTable::class];
        $this->TenantConfigSettings = TableRegistry::getTableLocator()->get('TenantConfigSettings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TenantConfigSettings);

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
