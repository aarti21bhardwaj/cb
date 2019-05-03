<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use App\Model\Entity\Course;
use Cake\Core\Configure;

/**
 * Courses Model
 *
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\BelongsTo $Locations
 * @property \App\Model\Table\TrainingSitesTable|\Cake\ORM\Association\BelongsTo $TrainingSites
 * @property \App\Model\Table\CorporateClientsTable|\Cake\ORM\Association\BelongsTo $CorporateClients
 * @property \App\Model\Table\CourseTypeCategoriesTable|\Cake\ORM\Association\BelongsTo $CourseTypeCategories
 * @property \App\Model\Table\CourseTypesTable|\Cake\ORM\Association\BelongsTo $CourseTypes
 * @property \App\Model\Table\CourseAddonsTable|\Cake\ORM\Association\HasMany $CourseAddons
 * @property \App\Model\Table\CourseDatesTable|\Cake\ORM\Association\HasMany $CourseDates
 * @property \App\Model\Table\CourseDisplayTypesTable|\Cake\ORM\Association\HasMany $CourseDisplayTypes
 * @property \App\Model\Table\CourseDocumentsTable|\Cake\ORM\Association\HasMany $CourseDocuments
 * @property \App\Model\Table\CourseInstructorsTable|\Cake\ORM\Association\HasMany $CourseInstructors
 * @property \App\Model\Table\CourseStudentsTable|\Cake\ORM\Association\HasMany $CourseStudents
 * @property |\Cake\ORM\Association\HasMany $LineItems
 *
 * @method \App\Model\Entity\Course get($primaryKey, $options = [])
 * @method \App\Model\Entity\Course newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Course[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Course|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Course|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Course patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Course[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Course findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CoursesTable extends Table
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

        $this->setTable('courses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Locations', [
            'foreignKey' => 'location_id'
        ]);
        $this->belongsTo('TrainingSites', [
            'foreignKey' => 'training_site_id'
        ]);
        $this->belongsTo('CorporateClients', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->belongsTo('CourseTypeCategories', [
            'foreignKey' => 'course_type_category_id',
            'joinType'=>'LEFT',
        ]);
        $this->belongsTo('CourseTypes', [
            'foreignKey' => 'course_type_id',
            'joinType'=>'INNER'
        ]);
        $this->belongsTo('Agencies', [
            'foreignKey' => 'agency_id',
            'joinType'=>'LEFT'
        ]);
        
        $this->hasMany('CourseAddons', [
            'joinType'=>'LEFT',
            'foreignKey' => 'course_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('CourseDates', [
            'joinType'=>'INNER',
            'foreignKey' => 'course_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);

        $this->hasMany('TransferCourses', [
            'joinType'=>'INNER',
            'foreignKey' => 'course_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);

        $this->hasMany('CourseDisplayTypes', [
            'joinType'=>'LEFT',
            'foreignKey' => 'course_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('CourseDocuments', [
            'joinType'=>'LEFT',
            'foreignKey' => 'course_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('CourseInstructors', [
            'joinType'=>'LEFT',
            'foreignKey' => 'course_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('CourseStudents', [
            'joinType'=>'LEFT',
            'foreignKey' => 'course_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        // $this->hasMany('CourseStudents', [
        //     'joinType'=>'LEFT',
        //     'foreignKey' => 'course_id',
        //     'saveStrategy' => 'replace',
        //     'dependent' => true,
        //     'cascadeCallback' => true
        // ]);
        $this->hasMany('LineItems', [
            'joinType'=>'LEFT',
            'foreignKey' => 'course_id'
        ]);
        //  $config = [
        //         'document_name' => [
        //         'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForCourseRoster'),
        //         'fields' => [
        //             'dir' => 'document_path'
        //         ],
        //         'nameCallback' => function ($data, $settings) {
        //             return time(). $data['name'];
        //             },
        //         ],
        // ];
        // if(Configure::read('uploadSetting') === 's3'){
            
        //     $config['document_name']['path'] = Configure::read('ImageUpload.uploadPathForCourseRoster'); 
        //     $config['document_name']['filesystem'] = [
        //             'adapter' => Configure::read('Josegonzalez/upload'),
        //         ];
        // }

        // $this->addBehavior('Josegonzalez/Upload.Upload', $config);
        $this->hasMany('StudentTransferHistories', [
            'joinType'=>'INNER',
            'foreignKey' => 'previous_course_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('StudentTransferHistories', [
            'joinType'=>'INNER',
            'foreignKey' => 'current_course_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
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
            ->scalar('duration')
            ->maxLength('duration', 255)
            ->requirePresence('duration', 'create')
            ->notEmpty('duration');

        $validator
            ->boolean('private_course')
            ->requirePresence('private_course', 'create')
            ->notEmpty('private_course');

        $validator
            ->scalar('pay_structure')
            ->maxLength('pay_structure', 255)
            ->allowEmpty('pay_structure');

        $validator
            ->scalar('instructor_pay')
            ->maxLength('instructor_pay', 255)
            ->allowEmpty('instructor_pay');

        $validator
            ->scalar('additional_pay')
            ->maxLength('additional_pay', 255)
            ->allowEmpty('additional_pay');

        $validator
            ->scalar('additional_notes')
            ->maxLength('additional_notes', 255)
            ->allowEmpty('additional_notes');

        $validator
            ->integer('seats')
            ->allowEmpty('seats');

        $validator
            ->scalar('cost')
            ->maxLength('cost', 255)
            ->allowEmpty('cost');

        $validator
            ->scalar('class_details')
            ->allowEmpty('class_details');

        $validator
            ->scalar('instructor_notes')
            ->allowEmpty('instructor_notes');

        $validator
            ->scalar('admin_notes')
            ->allowEmpty('admin_notes');

        $validator
            ->scalar('av_provided_by')
            ->maxLength('av_provided_by', 255)
            ->allowEmpty('av_provided_by');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('display_type')
            ->maxLength('display_type', 255)
            ->allowEmpty('display_type');

        $validator
            ->scalar('private_course_url')
            ->allowEmpty('private_course_url');

        $validator
            ->allowEmpty('document_name');

        $validator
            ->scalar('document_path')
            ->maxLength('document_path', 255)
            ->allowEmpty('document_path');

        $validator
            ->scalar('notes')
            ->allowEmpty('notes');

        $validator
            ->boolean('private_course_flag')
            ->allowEmpty('private_course_flag');

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
        $rules->add($rules->existsIn(['location_id'], 'Locations'));
        $rules->add($rules->existsIn(['training_site_id'], 'TrainingSites'));
        $rules->add($rules->existsIn(['corporate_client_id'], 'CorporateClients'));
        $rules->add($rules->existsIn(['course_type_category_id'], 'CourseTypeCategories'));
        $rules->add($rules->existsIn(['course_type_id'], 'CourseTypes'));

        return $rules;
    }
    public function beforeMarshal($event, $data, $options)
    {   
        // pr($data);die;
        if(isset($data['document_name'])){
            if(gettype($data['document_name']) == 'array'){
                $config = [
                    'document_name' => [
                    'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForCourseRoster'),
                    'fields' => [
                        'dir' => 'document_path'
                    ],
                    'nameCallback' => function ($data, $settings) {
                        return time(). $data['name'];
                        },
                    ],
            ];
            if(Configure::read('uploadSetting') === 's3'){
                $config['document_name']['path'] = Configure::read('ImageUpload.uploadPathForCourseRoster');
                $config['document_name']['filesystem'] = [
                        'adapter' => Configure::read('Josegonzalez/upload'),
                    ];
            }
            $this->addBehavior('Josegonzalez/Upload.Upload', $config);
            }
        }

        $length = 36;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        // pr($randomString);die();
        $data['private_course_url'] = $randomString;
        return $data;
        // pr($data[]);die('here');
    }

}
