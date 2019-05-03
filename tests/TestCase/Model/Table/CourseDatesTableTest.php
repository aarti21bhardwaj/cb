<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseDatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseDatesTable Test Case
 */
class CourseDatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseDatesTable
     */
    public $CourseDates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_dates',
        'app.courses'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CourseDates') ? [] : ['className' => CourseDatesTable::class];
        $this->CourseDates = TableRegistry::getTableLocator()->get('CourseDates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseDates);

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
