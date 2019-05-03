<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CardPrintingProfileTrainingSitesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CardPrintingProfileTrainingSitesTable Test Case
 */
class CardPrintingProfileTrainingSitesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CardPrintingProfileTrainingSitesTable
     */
    public $CardPrintingProfileTrainingSites;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.card_printing_profile_training_sites',
        'app.card_printing_profiles',
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
        $config = TableRegistry::getTableLocator()->exists('CardPrintingProfileTrainingSites') ? [] : ['className' => CardPrintingProfileTrainingSitesTable::class];
        $this->CardPrintingProfileTrainingSites = TableRegistry::getTableLocator()->get('CardPrintingProfileTrainingSites', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CardPrintingProfileTrainingSites);

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
