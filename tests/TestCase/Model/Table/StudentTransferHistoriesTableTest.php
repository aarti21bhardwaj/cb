<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StudentTransferHistoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StudentTransferHistoriesTable Test Case
 */
class StudentTransferHistoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StudentTransferHistoriesTable
     */
    public $StudentTransferHistories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.student_transfer_histories',
        'app.students',
        'app.previous_courses',
        'app.current_courses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StudentTransferHistories') ? [] : ['className' => StudentTransferHistoriesTable::class];
        $this->StudentTransferHistories = TableRegistry::getTableLocator()->get('StudentTransferHistories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StudentTransferHistories);

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
