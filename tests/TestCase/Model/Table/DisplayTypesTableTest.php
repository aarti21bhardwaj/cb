<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DisplayTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DisplayTypesTable Test Case
 */
class DisplayTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DisplayTypesTable
     */
    public $DisplayTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.display_types',
        'app.course_display_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('DisplayTypes') ? [] : ['className' => DisplayTypesTable::class];
        $this->DisplayTypes = TableRegistry::getTableLocator()->get('DisplayTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DisplayTypes);

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
}
