<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use App\Model\Entity\Instructor;
use Cake\Core\Configure;

/**
 * Instructors Model
 *
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\TrainingSitesTable|\Cake\ORM\Association\BelongsTo $TrainingSites
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\CourseInstructorsTable|\Cake\ORM\Association\HasMany $CourseInstructors
 * @property |\Cake\ORM\Association\HasMany $InstructorApplications
 * @property |\Cake\ORM\Association\HasMany $InstructorInsuranceForm
 * @property |\Cake\ORM\Association\HasMany $InstructorQualifications
 * @property |\Cake\ORM\Association\HasMany $InstructorReferences
 *
 * @method \App\Model\Entity\Instructor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Instructor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Instructor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Instructor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Instructor|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Instructor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Instructor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Instructor findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InstructorsTable extends Table
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

        $this->setTable('instructors');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TrainingSites', [
            'foreignKey' => 'training_site_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('CourseInstructors', [
            'foreignKey' => 'instructor_id'
        ]);
        $this->hasMany('InstructorApplications', [
            'foreignKey' => 'instructor_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('InstructorInsuranceForms', [
            'foreignKey' => 'instructor_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('InstructorQualifications', [
            'foreignKey' => 'instructor_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('InstructorReferences', [
            'foreignKey' => 'instructor_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $config = [
                'document_name' => [
                'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForInstructorQualifications'),
                'fields' => [
                    'dir' => 'document_path'
                ],
                'nameCallback' => function ($data, $settings) {
                    return time(). $data['name'];
                    },
                ],
        ];
        if(Configure::read('uploadSetting') === 's3'){
            $config['document_name']['path'] = Configure::read('ImageUpload.uploadPathForInstructorQualifications'); 
            $config['document_name']['filesystem'] = [
                    'adapter' => Configure::read('Josegonzalez/upload'),
                ];
        }
        $this->addBehavior('Josegonzalez/Upload.Upload', $config);
       $this->addBehavior('Muffin/Trash.Trash', [
            'field' => 'delete_at',
            // 'events' => ['Model.beforeFind']
        ]);
     
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
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->allowEmpty('image_name');

        $validator
            ->scalar('image_path')
            // ->maxLength('image_path', 255)
            ->allowEmpty('image_path');

        $validator
            ->scalar('phone_1')
            ->maxLength('phone_1', 15)
            ->allowEmpty('phone_1');

        $validator
            ->scalar('phone_2')
            ->maxLength('phone_2', 15)
            ->allowEmpty('phone_2');

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
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->datetime('delete_at')
            ->allowEmpty('delete_at');

        $validator
            ->uuid('token')
            ->requirePresence('token', 'create')
            ->notEmpty('token');

        $validator
            ->scalar('lat')
            ->maxLength('lat', 255)
            ->requirePresence('lat', 'create')
            ->notEmpty('lat');

        $validator
            ->scalar('lng')
            ->maxLength('lng', 255)
            ->requirePresence('lng', 'create')
            ->notEmpty('lng');
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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['tenant_id'], 'Tenants'));
        $rules->add($rules->existsIn(['training_site_id'], 'TrainingSites'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }

    //  public function beforeMarshal($event, $data, $options){
    //    if (!isset($data['token'])) {
    //        $data['token'] = Text::uuid();
    //    }
    // }

}
