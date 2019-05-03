<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InstructorResetPasswordHashesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InstructorResetPasswordHashesTable Test Case
 */
class InstructorResetPasswordHashesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InstructorResetPasswordHashesTable
     */
    public $InstructorResetPasswordHashes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.instructor_reset_password_hashes',
        'app.instructors'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('InstructorResetPasswordHashes') ? [] : ['className' => InstructorResetPasswordHashesTable::class];
        $this->InstructorResetPasswordHashes = TableRegistry::getTableLocator()->get('InstructorResetPasswordHashes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InstructorResetPasswordHashes);

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
