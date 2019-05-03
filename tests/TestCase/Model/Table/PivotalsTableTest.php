<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PivotalsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PivotalsTable Test Case
 */
class PivotalsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PivotalsTable
     */
    public $Pivotals;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.pivotals',
        'app.key_categories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Pivotals') ? [] : ['className' => PivotalsTable::class];
        $this->Pivotals = TableRegistry::getTableLocator()->get('Pivotals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Pivotals);

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
