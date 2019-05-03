<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TenantsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TenantsTable Test Case
 */
class TenantsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TenantsTable
     */
    public $Tenants;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tenants',
        'app.roles',
        'app.addons',
        'app.corporate_clients',
        'app.course_type_categories',
        'app.courses',
        'app.instructors',
        'app.key_categories',
        'app.locations',
        'app.tenant_old_passwords',
        'app.tenant_settings',
        'app.tenant_users',
        'app.training_sites',
        'app.text_clips'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Tenants') ? [] : ['className' => TenantsTable::class];
        $this->Tenants = TableRegistry::getTableLocator()->get('Tenants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tenants);

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
