<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TenantThemesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TenantThemesTable Test Case
 */
class TenantThemesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TenantThemesTable
     */
    public $TenantThemes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tenant_themes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TenantThemes') ? [] : ['className' => TenantThemesTable::class];
        $this->TenantThemes = TableRegistry::getTableLocator()->get('TenantThemes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TenantThemes);

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
}
