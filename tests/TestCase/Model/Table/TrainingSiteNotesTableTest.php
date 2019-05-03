<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TrainingSiteNotesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TrainingSiteNotesTable Test Case
 */
class TrainingSiteNotesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TrainingSiteNotesTable
     */
    public $TrainingSiteNotes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.training_site_notes',
        'app.training_sites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TrainingSiteNotes') ? [] : ['className' => TrainingSiteNotesTable::class];
        $this->TrainingSiteNotes = TableRegistry::getTableLocator()->get('TrainingSiteNotes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TrainingSiteNotes);

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
