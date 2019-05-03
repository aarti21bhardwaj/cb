<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CorporateClientUsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CorporateClientUsersTable Test Case
 */
class CorporateClientUsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CorporateClientUsersTable
     */
    public $CorporateClientUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.corporate_client_users',
        'app.corporate_clients',
        'app.roles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CorporateClientUsers') ? [] : ['className' => CorporateClientUsersTable::class];
        $this->CorporateClientUsers = TableRegistry::getTableLocator()->get('CorporateClientUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CorporateClientUsers);

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
