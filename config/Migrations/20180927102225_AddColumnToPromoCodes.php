<?php
use Migrations\AbstractMigration;

class AddColumnToPromoCodes extends AbstractMigration
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
        $table = $this->table('promo_codes');
        $table->addColumn('restrict_by_course_types', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('restrict_by_email', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->update();
    }
}
