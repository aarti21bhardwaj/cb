<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IndexSettingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IndexSettingsTable Test Case
 */
class IndexSettingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\IndexSettingsTable
     */
    public $IndexSettings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.index_settings',
        'app.fors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('IndexSettings') ? [] : ['className' => IndexSettingsTable::class];
        $this->IndexSettings = TableRegistry::getTableLocator()->get('IndexSettings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IndexSettings);

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
