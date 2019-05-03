<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use App\Model\Entity\InstructorQualification;
use Cake\Core\Configure;


/**
 * InstructorQualifications Model
 *
 * @property \App\Model\Table\InstructorsTable|\Cake\ORM\Association\BelongsTo $Instructors
 * @property \App\Model\Table\QualificationsTable|\Cake\ORM\Association\BelongsTo $Qualifications
 * @property \App\Model\Table\QualificationTypesTable|\Cake\ORM\Association\BelongsTo $QualificationTypes
 *
 * @method \App\Model\Entity\InstructorQualification get($primaryKey, $options = [])
 * @method \App\Model\Entity\InstructorQualification newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InstructorQualification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InstructorQualification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InstructorQualification|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InstructorQualification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InstructorQualification[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InstructorQualification findOrCreate($search, callable $callback = null, $options = [])
 */
class InstructorQualificationsTable extends Table
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

        $this->setTable('instructor_qualifications');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Instructors', [
            'foreignKey' => 'instructor_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Qualifications', [
            'foreignKey' => 'qualification_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('QualificationTypes', [
            'foreignKey' => 'qualification_type_id',
            'joinType' => 'LEFT'
        ]);
        //  $config = [
        //         'document_name' => [
        //         'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForInstructorQualifications'),
        //         'fields' => [
        //             'dir' => 'document_path'
        //         ],
        //         'nameCallback' => function ($data, $settings) {
        //             return time(). $data['name'];
        //             },
        //         ],
        //     ];
        // if(Configure::read('uploadSetting') === 's3'){
        //     $config['document_name']['path'] = Configure::read('ImageUpload.uploadPathForInstructorQualifications'); 
        //     $config['document_name']['filesystem'] = [
        //             'adapter' => Configure::read('Josegonzalez/upload'),
        //         ];
        // }
        // $this->addBehavior('Josegonzalez/Upload.Upload', $config);
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
            ->date('expiry_date')
            ->requirePresence('expiry_date', 'create')
            ->notEmpty('expiry_date');

        $validator
            ->date('last_monitored')
            ->requirePresence('last_monitored', 'create')
            ->notEmpty('last_monitored');

        $validator
            ->scalar('license_number')
            ->maxLength('license_number', 255)
            ->requirePresence('license_number', 'create')
            ->notEmpty('license_number');

        $validator
            // ->scalar('document_name')
            // ->maxLength('document_name', 255)
            // ->requirePresence('document_name', 'create')
            ->allowEmpty('document_name');

        $validator
            ->scalar('document_path')
            // ->maxLength('document_path', 255)
            // ->requirePresence('document_path', 'create')
            ->allowEmpty('document_path');

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
        $rules->add($rules->existsIn(['instructor_id'], 'Instructors'));
        $rules->add($rules->existsIn(['qualification_id'], 'Qualifications'));
        $rules->add($rules->existsIn(['qualification_type_id'], 'QualificationTypes'));

        return $rules;
    }
    public function beforeMarshal($event, $data, $options){
        if(isset($data['document_name'])){
        if(gettype($data['document_name']) == 'array'){
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
        }
    }
    }
}
