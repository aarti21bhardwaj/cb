<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use App\Model\Entity\Tenant;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\NotFoundException;



/**
 * Tenants Model
 *
 * @property \App\Model\Table\AddonsTable|\Cake\ORM\Association\HasMany $Addons
 * @property \App\Model\Table\CorporateClientsTable|\Cake\ORM\Association\HasMany $CorporateClients
 * @property \App\Model\Table\CourseTypeCategoriesTable|\Cake\ORM\Association\HasMany $CourseTypeCategories
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 * @property \App\Model\Table\InstructorsTable|\Cake\ORM\Association\HasMany $Instructors
 * @property \App\Model\Table\KeyCategoriesTable|\Cake\ORM\Association\HasMany $KeyCategories
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\HasMany $Locations
 * @property |\Cake\ORM\Association\HasMany $PromoCodes
 * @property |\Cake\ORM\Association\HasMany $Students
 * @property \App\Model\Table\TenantSettingsTable|\Cake\ORM\Association\HasMany $TenantSettings
 * @property \App\Model\Table\TenantUsersTable|\Cake\ORM\Association\HasMany $TenantUsers
 * @property \App\Model\Table\TextClipsTable|\Cake\ORM\Association\HasMany $TextClips
 * @property \App\Model\Table\TrainingSitesTable|\Cake\ORM\Association\HasMany $TrainingSites
 *
 * @method \App\Model\Entity\Tenant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tenant newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tenant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tenant|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tenant|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tenant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tenant[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tenant findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TenantsTable extends Table
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

        $this->setTable('tenants');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
         $this->hasMany('Emails', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('Addons', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('CorporateClients', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('CourseTypeCategories', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('Instructors', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('KeyCategories', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('Locations', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('PromoCodes', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('Students', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('TenantSettings', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('TenantUsers', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true

        ]);
        $this->hasMany('TextClips', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('TrainingSites', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('TenantThemes', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('TenantConfigSettings', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('CardPrintingProfileTrainingSites', [
            'foreignKey' => 'tenant_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $config = [
                'image_name' => [
                'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForTenantsImages'),
                'fields' => [
                    'dir' => 'image_path'
                ],
                'nameCallback' => function ($data, $settings) {
                    return time(). $data['name'];
                    },
                ],
            ];
        if(Configure::read('uploadSetting') === 's3'){
            $config['image_name']['path'] = Configure::read('ImageUpload.uploadPathForTenantsImages'); 
            $config['image_name']['filesystem'] = [
                    'adapter' => Configure::read('Josegonzalez/upload'),
                ];
        }
        $this->addBehavior('Josegonzalez/Upload.Upload', $config);
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
            ->scalar('center_name')
            ->maxLength('center_name', 255)
            ->requirePresence('center_name', 'create')
            ->allowEmpty('center_name');

        $validator
            ->scalar('address')
            ->allowEmpty('address');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->requirePresence('city', 'create')
            ->allowEmpty('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 255)
            ->requirePresence('state', 'create')
            ->allowEmpty('state');

        $validator
            ->scalar('zip')
            ->maxLength('zip', 255)
            ->requirePresence('zip', 'create')
            ->allowEmpty('zip');

        $validator
            ->scalar('email')
            ->maxLength('email', 255)
            ->requirePresence('email', 'create')
            ->allowEmpty('email');

        $validator
            ->scalar('domain_type')
            ->maxLength('domain_type', 255)
            ->requirePresence('domain_type', 'create')
            ->allowEmpty('domain_type');

        $validator
            ->boolean('status')
            ->allowEmpty('status');

        $validator
            ->allowEmpty('image_name');

        $validator
            ->scalar('image_path')
            ->allowEmpty('image_path');

        $validator
            ->scalar('uuid')
            ->maxLength('uuid', 255)
            ->allowEmpty('uuid');

        return $validator;
    }
    public function afterSave($event,$entity, $options){
        if ($entity->isNew()) {
            $events = Configure::read('events');
            $this->Emails = TableRegistry::get('Emails');        
            $emails = [] ;
            foreach ($events as $key => $value) {
                $value['emails'][0]['tenant_id'] = $entity->id;
                $value['emails'][0]['event_id'] = $key+1;
                if($this->Emails->find()->where($value['emails'][0])->first()){
                   continue;    
                }
                $emails[] = $value['emails'][0];
            }
            if(isset($emails) && !empty($emails)){
                $entities = $this->Emails->newEntities($emails);
                 if(!$this->Emails->saveMany($entities)){
                        throw new NotFoundException(__('Emails Data not saved'));
                 }
            }
        }
    }

    public function beforeMarshal($event,$entity,$options){
        $file = WWW_ROOT.'courseTypes.json';
        $courseTypeData = json_decode(file_get_contents($file), True);
        $entity['course_type_categories'] = $courseTypeData;
        if (!isset($data['uuid'])) {
           $data['uuid'] = Text::uuid();
       }

    }
    public function beforeSave($event,$entity,$options){
        if(!$entity->isNew()){
            unset($entity['course_type_categories']);
        }
    }
}
