<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseDisplayTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseDisplayTypesTable Test Case
 */
class CourseDisplayTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseDisplayTypesTable
     */
    public $CourseDisplayTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_display_types',
        'app.courses',
        'app.display_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CourseDisplayTypes') ? [] : ['className' => CourseDisplayTypesTable::class];
        $this->CourseDisplayTypes = TableRegistry::getTableLocator()->get('CourseDisplayTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseDisplayTypes);

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
