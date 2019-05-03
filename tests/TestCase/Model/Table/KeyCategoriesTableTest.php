<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\KeyCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\KeyCategoriesTable Test Case
 */
class KeyCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\KeyCategoriesTable
     */
    public $KeyCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.key_categories',
        'app.tenants',
        'app.addons',
        'app.keys'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('KeyCategories') ? [] : ['className' => KeyCategoriesTable::class];
        $this->KeyCategories = TableRegistry::getTableLocator()->get('KeyCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->KeyCategories);

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
