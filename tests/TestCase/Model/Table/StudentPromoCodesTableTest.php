<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StudentPromoCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StudentPromoCodesTable Test Case
 */
class StudentPromoCodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StudentPromoCodesTable
     */
    public $StudentPromoCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.student_promo_codes',
        'app.students',
        'app.promo_codes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StudentPromoCodes') ? [] : ['className' => StudentPromoCodesTable::class];
        $this->StudentPromoCodes = TableRegistry::getTableLocator()->get('StudentPromoCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StudentPromoCodes);

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
