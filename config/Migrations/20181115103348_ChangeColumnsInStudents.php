<?php
use Migrations\AbstractMigration;

class ChangeColumnsInStudents extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('students');
        $table->changeColumn('address', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->changeColumn('city', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->changeColumn('state', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
         $table->changeColumn('zipcode', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
          $table->changeColumn('phone1', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->changeColumn('phone2', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
         $table->changeColumn('status', 'boolean', [
            'default' => 1,
            'null' => false,
        ]);
        $table->update();

    }
}
