<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CardPrintingProfilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CardPrintingProfilesTable Test Case
 */
class CardPrintingProfilesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CardPrintingProfilesTable
     */
    public $CardPrintingProfiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.card_printing_profiles',
        'app.card_printing_profile_training_sites'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CardPrintingProfiles') ? [] : ['className' => CardPrintingProfilesTable::class];
        $this->CardPrintingProfiles = TableRegistry::getTableLocator()->get('CardPrintingProfiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CardPrintingProfiles);

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
