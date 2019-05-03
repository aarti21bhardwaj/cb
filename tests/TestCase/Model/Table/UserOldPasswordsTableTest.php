<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserOldPasswordsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserOldPasswordsTable Test Case
 */
class UserOldPasswordsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UserOldPasswordsTable
     */
    public $UserOldPasswords;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.user_old_passwords',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UserOldPasswords') ? [] : ['className' => UserOldPasswordsTable::class];
        $this->UserOldPasswords = TableRegistry::getTableLocator()->get('UserOldPasswords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserOldPasswords);

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
