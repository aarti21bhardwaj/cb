<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LineItemsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LineItemsTable Test Case
 */
class LineItemsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LineItemsTable
     */
    public $LineItems;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.line_items',
        'app.orders',
        'app.addons',
        'app.courses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('LineItems') ? [] : ['className' => LineItemsTable::class];
        $this->LineItems = TableRegistry::getTableLocator()->get('LineItems', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LineItems);

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
