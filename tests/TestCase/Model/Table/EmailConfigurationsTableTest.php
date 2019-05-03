<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmailConfigurationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmailConfigurationsTable Test Case
 */
class EmailConfigurationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmailConfigurationsTable
     */
    public $EmailConfigurations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.email_configurations',
        'app.emails'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmailConfigurations') ? [] : ['className' => EmailConfigurationsTable::class];
        $this->EmailConfigurations = TableRegistry::getTableLocator()->get('EmailConfigurations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailConfigurations);

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
