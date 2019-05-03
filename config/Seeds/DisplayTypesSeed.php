<?php
use Migrations\AbstractSeed;

/**
 * DisplayTypes seed.
 */
class DisplayTypesSeed extends AbstractSeed
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
        $data = [];

        $table = $this->table('display_types');
        $data = array(
                         array('id' => '1','name' => 'Television','status' => '1'),
                         array('id' => '2','name' => 'Projector','status' => '1'),
                         array('id' => '3','name' => 'DVD','status' => '1'),
                         array('id' => '4','name' => 'Laptop','status' => '1'),
                         array('id' => '5','name' => 'Desktop','status' => '1'),
                         array('id' => '6','name' => 'Remote Control ','status' => '1'),
                         array('id' => '7','name' => 'Laser Pointer','status' => '1'),
                         array('id' => '8','name' => 'Extension Cord','status' => '1')
                        );
        $table->insert($data)->save();
    }
}
