<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PromoCodesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PromoCodesTable Test Case
 */
class PromoCodesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PromoCodesTable
     */
    public $PromoCodes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.promo_codes',
        'app.tenants',
        'app.subcontracted_clients',
        'app.corporate_clients',
        'app.promo_code_course_types',
        'app.promo_code_emails',
        'app.course_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PromoCodes') ? [] : ['className' => PromoCodesTable::class];
        $this->PromoCodes = TableRegistry::getTableLocator()->get('PromoCodes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PromoCodes);

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
