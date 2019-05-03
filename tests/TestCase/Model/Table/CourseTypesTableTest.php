<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseTypesTable Test Case
 */
class CourseTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseTypesTable
     */
    public $CourseTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_types',
        'app.course_type_categories',
        'app.agencies',
        'app.course_type_qualifications',
        'app.courses',
        'app.promo_code_course_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CourseTypes') ? [] : ['className' => CourseTypesTable::class];
        $this->CourseTypes = TableRegistry::getTableLocator()->get('CourseTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseTypes);

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
