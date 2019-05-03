<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseTypeCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseTypeCategoriesTable Test Case
 */
class CourseTypeCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseTypeCategoriesTable
     */
    public $CourseTypeCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_type_categories',
        'app.tenants',
        'app.course_types',
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
        $config = TableRegistry::getTableLocator()->exists('CourseTypeCategories') ? [] : ['className' => CourseTypeCategoriesTable::class];
        $this->CourseTypeCategories = TableRegistry::getTableLocator()->get('CourseTypeCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseTypeCategories);

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
