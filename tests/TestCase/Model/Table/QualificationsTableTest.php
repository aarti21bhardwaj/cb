<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\QualificationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\QualificationsTable Test Case
 */
class QualificationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\QualificationsTable
     */
    public $Qualifications;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.qualifications',
        'app.course_type_qualifications'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Qualifications') ? [] : ['className' => QualificationsTable::class];
        $this->Qualifications = TableRegistry::getTableLocator()->get('Qualifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Qualifications);

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
