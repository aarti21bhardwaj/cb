<?php
use Migrations\AbstractMigration;

class CreateTenantConfigSettings extends AbstractMigration
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
        $table = $this->table('tenant_config_settings');
        $table->addColumn('tenant_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => true,
        ]);
        $table->addColumn('card_print', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('instructor_bidding', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('portal_password', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('instructor_photo', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('sandbox', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('payment_mode', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('stripe_test_published_key', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('stripe_test_private_key', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('stripe_live_published_key', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('stripe_live_private_key', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('termcondition', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('hear_about', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('course_description', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('location_notes', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('class_details', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('remaining_seats', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('promocode', 'boolean', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
