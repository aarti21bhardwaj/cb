<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HashMapsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HashMapsTable Test Case
 */
class HashMapsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HashMapsTable
     */
    public $HashMaps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.hash_maps',
        'app.olds',
        'app.news'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('HashMaps') ? [] : ['className' => HashMapsTable::class];
        $this->HashMaps = TableRegistry::getTableLocator()->get('HashMaps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HashMaps);

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
