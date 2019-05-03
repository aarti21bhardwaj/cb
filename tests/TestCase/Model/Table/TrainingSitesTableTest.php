<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrainingSitesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrainingSitesTable Test Case
 */
class TrainingSitesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TrainingSitesTable
     */
    public $TrainingSites;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.training_sites',
        'app.tenants',
        'app.corporate_clients',
        'app.courses',
        'app.instructors',
        'app.locations',
        'app.training_site_notes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TrainingSites') ? [] : ['className' => TrainingSitesTable::class];
        $this->TrainingSites = TableRegistry::getTableLocator()->get('TrainingSites', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TrainingSites);

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
