<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TextClipsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TextClipsTable Test Case
 */
class TextClipsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TextClipsTable
     */
    public $TextClips;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.text_clips',
        'app.tenants'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('TextClips') ? [] : ['className' => TextClipsTable::class];
        $this->TextClips = TableRegistry::getTableLocator()->get('TextClips', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TextClips);

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
