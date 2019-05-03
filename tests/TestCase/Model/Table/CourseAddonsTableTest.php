<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CourseAddonsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CourseAddonsTable Test Case
 */
class CourseAddonsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CourseAddonsTable
     */
    public $CourseAddons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.course_addons',
        'app.courses',
        'app.addons'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CourseAddons') ? [] : ['className' => CourseAddonsTable::class];
        $this->CourseAddons = TableRegistry::getTableLocator()->get('CourseAddons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CourseAddons);

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
