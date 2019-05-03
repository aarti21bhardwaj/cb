<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StudentResetPasswordHashesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StudentResetPasswordHashesTable Test Case
 */
class StudentResetPasswordHashesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StudentResetPasswordHashesTable
     */
    public $StudentResetPasswordHashes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.student_reset_password_hashes',
        'app.students'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StudentResetPasswordHashes') ? [] : ['className' => StudentResetPasswordHashesTable::class];
        $this->StudentResetPasswordHashes = TableRegistry::getTableLocator()->get('StudentResetPasswordHashes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StudentResetPasswordHashes);

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
