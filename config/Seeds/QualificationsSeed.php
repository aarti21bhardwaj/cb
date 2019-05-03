<?php
use Migrations\AbstractSeed;

/**
 * Qualtifications seed.
 */
class QualificationsSeed extends AbstractSeed
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
                    // [
                    //     'name' => 'AHA - PALS',
                    //     'status' => 1
                    // ] , 

                    // [
                    //     'name' => 'AHA - BLS',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'AHA - ACLS',
                    //     'status' => 1
                    // ] , 
                    // [
                    //     'name' => 'AHA - Pears',
                    //     'status' => 1
                    // ] , 
                    // [
                    //     'name' => 'AHA - HeartSaver CPR/AED/FA',
                    //     'status' => 1
                    // ] , 
                    // [
                    //     'name' => 'AHA - ACLS EP',
                    //     'status' => 1
                    // ] , 
                    // [
                    //     'name' => 'American-CarePlus CPR/AED/FA',
                    //     'status' => 1
                    // ] , 
                    // [
                    //     'name' => 'American- BasicPlus CPR/AED/FA',
                    //     'status' => 1
                    // ] , 
                    
                    // [
                    //     'name' => 'American- PediatricPlus CPR/AED/FA',
                    //     'status' => 1
                    // ] , 
                    // [
                    //     'name' => 'American-BBP',
                    //     'status' => 1
                    // ] , 
                    // [
                    //     'name' => 'ASHI- Basic CPR',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ASHI- Pediatric CPR/AED/FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ASHI- Wilderness FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ASHI- Pro Rescuer',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ASHI- Advanced FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ASHI- EMR',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ASHI- ACLS',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ASHI- PALS',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ASHI- Wilderness First Responder',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ASHI- Wilderness EMT Upgrade',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ASHI- CABS/Babysitter',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ASHI- BBP',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG- Emergency O2',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG- Standard CPR/AED/FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG-PedFACTS/Pediatric CPR/AED/FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG- Health Care Provider CPR/BLS',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG-Wilderness FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG-Boy Scouts Wilderness FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG-Pet First Aid',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG-Sports First Aid',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG-Advanced CPR/AED/FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG-EMR',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG-eACLS',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG-BLAST/Babysitter',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG-BBP',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'ECSI/PSG-Fleet Driver Safety',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'NSC-CPR/AED/FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'NSC-Pediatric CPR/AED/FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'NSC-BLS',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'NSC-Advanced FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'NSC-EMR',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'NSC-BBP',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-BLS',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-CPR/AED/FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-Pro Rescuer/BLS HCP',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-Wilderness FA',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-Pet First Aid',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-EMR',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-ACLS',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-PALS',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-Babysitter',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-BBP',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-Emergency O2',
                    //     'status' => 1
                    // ] ,
                    // [
                    //     'name' => 'Red Cross-Lifeguarding',
                    //     'status' => 1
                    // ]
                        [
                            'name' => '24/7 EMS',
                            'status' => '1'

                        ] ,
                        [
                            'name' => '24/7 Fire',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'AHA',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'American',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'ASHI',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'ECSI/PSG',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'EI/Single Source Service',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'EI/Single Source Training',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'EMS Safety',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'Medic First Aid',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'NAEMT',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'NSC',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'OSHA',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'Red Cross',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'SafetySkills',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'Summit Training',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'WMI',
                            'status' => '1'

                        ] ,
                        [
                            'name' => 'Other',
                            'status' => '1'

                        ] ,


                ];

        $table = $this->table('qualifications');
        $table->insert($data)->save();
    }
}
