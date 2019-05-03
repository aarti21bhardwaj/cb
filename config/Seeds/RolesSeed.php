<?php
use Migrations\AbstractSeed;

/**
 * Roles seed.
 */
class RolesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
                   [
                    'name' => 'super_admin',
                    'label' => 'Super Admin'
                   ],
                   [
                    'name' => 'tenant',
                    'label' => 'Tenant'
                   ],
                   [
                    'name' => 'corporate_client',
                    'label' => 'Corporate Client'
                   ],
                   [
                    'name' => 'instructor',
                    'label' => 'Instructor'
                   ],
                   [
                    'name' => 'student',
                    'label' => 'Student'
                   ],
                   [
                    'name' => 'training_site',
                    'label' => 'Training Site'
                   ],
                ];

        $table = $this->table('roles');
        $table->insert($data)->save();
    }
}
