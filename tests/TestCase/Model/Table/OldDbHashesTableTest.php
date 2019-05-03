<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OldDbHashesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OldDbHashesTable Test Case
 */
class OldDbHashesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OldDbHashesTable
     */
    public $OldDbHashes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.old_db_hashes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('OldDbHashes') ? [] : ['className' => OldDbHashesTable::class];
        $this->OldDbHashes = TableRegistry::getTableLocator()->get('OldDbHashes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OldDbHashes);

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
