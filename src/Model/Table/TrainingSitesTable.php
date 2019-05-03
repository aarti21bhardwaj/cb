<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use Cake\Core\Configure;
use App\Model\Entity\TrainingSiteContract;


/**
 * TrainingSites Model
 *
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 * @property |\Cake\ORM\Association\HasMany $CardPrintingProfileTrainingSites
 * @property \App\Model\Table\CorporateClientsTable|\Cake\ORM\Association\HasMany $CorporateClients
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 * @property \App\Model\Table\InstructorsTable|\Cake\ORM\Association\HasMany $Instructors
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\HasMany $Locations
 * @property |\Cake\ORM\Association\HasMany $Students
 * @property |\Cake\ORM\Association\HasMany $SubcontractedClients
 * @property |\Cake\ORM\Association\HasMany $TenantUsers
 * @property \App\Model\Table\TrainingSiteNotesTable|\Cake\ORM\Association\HasMany $TrainingSiteNotes
 *
 * @method \App\Model\Entity\TrainingSite get($primaryKey, $options = [])
 * @method \App\Model\Entity\TrainingSite newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TrainingSite[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TrainingSite|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TrainingSite|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TrainingSite patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TrainingSite[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TrainingSite findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TrainingSitesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('training_sites');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('CardPrintingProfileTrainingSites', [
            'foreignKey' => 'training_site_id'
        ]);
        $this->hasMany('CorporateClients', [
            'foreignKey' => 'training_site_id'
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'training_site_id'
        ]);
        $this->hasMany('Instructors', [
            'foreignKey' => 'training_site_id'
        ]);
        $this->hasMany('Locations', [
            'foreignKey' => 'training_site_id'
        ]);
        $this->hasMany('Students', [
            'foreignKey' => 'training_site_id'
        ]);
        $this->hasMany('SubcontractedClients', [
            'foreignKey' => 'training_site_id'
        ]);
        $this->hasMany('TenantUsers', [
            'foreignKey' => 'training_site_id'
        ]);
        $this->hasMany('TrainingSiteNotes', [
            'foreignKey' => 'training_site_id'
        ]);

        $config = [
          'site_insurance_name' => [
            'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForTrainingSiteInsurance'),
            'fields' => [
                'dir' => 'site_insurance_path'
            ],
            'nameCallback' => function ($data, $settings) {
              return time(). $data['name'];
            },
          ],
          'site_contract_name' => [
            'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForTrainingSiteContract'),
            'fields' => [
              'dir' => 'site_contract_path'
            ],
            'nameCallback' => function ($data, $settings) {
              return time(). $data['name'];
            },
          ],
          'site_monitoring_name' => [
            'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForTrainingSiteMonitoringForm'),
            'fields' => [
              'dir' => 'site_monitoring_path'
            ],
            'nameCallback' => function ($data, $settings) {
              return time(). $data['name'];
            },
          ],
        ];
        if(Configure::read('uploadSetting') === 's3'){
            $config['site_insurance_name']['path'] = Configure::read('ImageUpload.uploadPathForTenantsImages'); 
            $config['site_insurance_name']['filesystem'] = [
                    'adapter' => Configure::read('Josegonzalez/upload'),
                ];
            $config['site_contract_name']['path'] = Configure::read('ImageUpload.uploadPathForTenantsImages'); 
            $config['site_contract_name']['filesystem'] = [
                    'adapter' => Configure::read('Josegonzalez/upload'),
                ];
            $config['site_monitoring_name']['path'] = Configure::read('ImageUpload.uploadPathForTenantsImages'); 
            $config['site_monitoring_name']['filesystem'] = [
                    'adapter' => Configure::read('Josegonzalez/upload'),
                ];
            
        }
        $this->addBehavior('Josegonzalez/Upload.Upload', $config);
        // $this->addBehavior('Josegonzalez/Upload.Upload', [
        //   'site_insurance_name' => [
        //     'path' => Configure::read('ImageUpload.uploadPathForTrainingSiteInsurance'),
        //     'fields' => [
        //       'dir' => 'site_insurance_path'
        //     ],
        //     'nameCallback' => function ($data, $settings) {
        //       return time(). $data['name'];
        //     },
        //   ],
        //   'site_contract_name' => [
        //     'path' => Configure::read('ImageUpload.uploadPathForTrainingSiteContract'),
        //     'fields' => [
        //       'dir' => 'site_contract_path'
        //     ],
        //     'nameCallback' => function ($data, $settings) {
        //       return time(). $data['name'];
        //     },
        //   ],
        //   'site_monitoring_name' => [
        //     'path' => Configure::read('ImageUpload.uploadPathForTrainingSiteMonitoringForm'),
        //     'fields' => [
        //       'dir' => 'site_monitoring_path'
        //     ],
        //     'nameCallback' => function ($data, $settings) {
        //       return time(). $data['name'];
        //     },
        //   ],
        // ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('training_site_code')
            ->maxLength('training_site_code', 255)
            ->allowEmpty('training_site_code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 255)
            ->requirePresence('phone', 'create')
            ->notEmpty('phone');

        $validator
            ->scalar('address')
            ->allowEmpty('address');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->requirePresence('city', 'create')
            ->notEmpty('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 255)
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->scalar('zipcode')
            ->maxLength('zipcode', 255)
            ->requirePresence('zipcode', 'create')
            ->notEmpty('zipcode');

        $validator
            ->scalar('contact_name')
            ->maxLength('contact_name', 255)
            ->requirePresence('contact_name', 'create')
            ->notEmpty('contact_name');

        $validator
            ->scalar('contact_email')
            ->maxLength('contact_email', 255)
            ->requirePresence('contact_email', 'create')
            ->notEmpty('contact_email');

        $validator
            ->scalar('contact_phone')
            ->maxLength('contact_phone', 255)
            ->requirePresence('contact_phone', 'create')
            ->notEmpty('contact_phone');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            // ->scalar('site_contract_name')
            ->allowEmpty('site_contract_name');

        $validator
            ->scalar('site_contract_path')
            ->allowEmpty('site_contract_path');

        $validator
            ->date('site_contract_date')
            ->allowEmpty('site_contract_date');

        $validator
            ->allowEmpty('site_monitoring_name');

        $validator
            ->scalar('site_monitoring_path')
            ->allowEmpty('site_monitoring_path');

        $validator
            ->date('site_monitoring_date')
            ->allowEmpty('site_monitoring_date');

        $validator
            ->allowEmpty('site_insurance_name');

        $validator
            ->scalar('site_insurance_path')
            ->allowEmpty('site_insurance_path');

        $validator
            ->date('site_insurance_expiry_date')
            ->allowEmpty('site_insurance_expiry_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['tenant_id'], 'Tenants'));

        return $rules;
    }
}
