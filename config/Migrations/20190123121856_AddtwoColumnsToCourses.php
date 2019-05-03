<?php
use Migrations\AbstractMigration;

class AddtwoColumnsToCourses extends AbstractMigration
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
        $table = $this->table('courses');
        $table->addColumn('instructor_bidding', 'boolean', [
            'default' => 0,
            'null' => true,
        ]);
        $table->addColumn('bidding_number', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->update();
    }
}
