<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AddonsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AddonsTable Test Case
 */
class AddonsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AddonsTable
     */
    public $Addons;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.addons',
        'app.tenants',
        'app.key_categories',
        'app.course_addons'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Addons') ? [] : ['className' => AddonsTable::class];
        $this->Addons = TableRegistry::getTableLocator()->get('Addons', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Addons);

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
