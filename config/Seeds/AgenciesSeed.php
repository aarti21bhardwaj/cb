<?php
use Migrations\AbstractSeed;

/**
 * Agencies seed.
 */
class AgenciesSeed extends AbstractSeed
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
                        'name' => 'AHA',
                    ] ,
                    [
                        'name' => 'Red Cross',
                    ] ,
                    [
                        'name' => 'EMS Safety',
                    ] ,
                    [
                        'name' => 'ASHI',
                    ] ,
                    [
                        'name' => 'Medic First Aid',
                    ] ,
                    [
                        'name' => 'NSC',
                    ] ,
                    [
                        'name' => 'OSHA',
                    ] ,
                    [
                        'name' => 'ECSI/PSG',
                    ] ,
                    [
                        'name' => 'American',
                    ] ,
                    [
                        'name' => 'Other',
                    ] ,
                    [
                        'name' => 'WMI',
                    ] ,
                    [
                        'name' => 'NAEMT',
                    ] ,
                    [
                        'name' => 'EI/Single Source Training',
                    ] ,
                    [
                        'name' => 'EI/Single Source Service',
                    ] ,
                    [
                        'name' => 'Summit Training',
                    ] ,
                    [
                        'name' => '24/7 EMS',
                    ] ,
                    [
                        'name' => '24/7 Fire',
                    ] ,
                    [
                        'name' => 'SafetySkills',
                    ] ,


        ];

        $table = $this->table('agencies');
        $table->insert($data)->save();
    }
}
