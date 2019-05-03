<?php
namespace App\Test\TestCase\Controller;

use App\Controller\TenantsController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\TenantsController Test Case
 */
class TenantsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tenants',
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
        'app.training_sites'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
