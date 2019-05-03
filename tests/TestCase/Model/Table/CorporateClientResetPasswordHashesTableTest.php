<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CorporateClientResetPasswordHashesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CorporateClientResetPasswordHashesTable Test Case
 */
class CorporateClientResetPasswordHashesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CorporateClientResetPasswordHashesTable
     */
    public $CorporateClientResetPasswordHashes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.corporate_client_reset_password_hashes',
        'app.corporate_client_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CorporateClientResetPasswordHashes') ? [] : ['className' => CorporateClientResetPasswordHashesTable::class];
        $this->CorporateClientResetPasswordHashes = TableRegistry::getTableLocator()->get('CorporateClientResetPasswordHashes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CorporateClientResetPasswordHashes);

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
