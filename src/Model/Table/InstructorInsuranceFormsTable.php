<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use App\Model\Entity\InstructorInsuranceForm;
use Cake\Core\Configure;

/**
 * InstructorInsuranceForms Model
 *
 * @property \App\Model\Table\InstructorsTable|\Cake\ORM\Association\BelongsTo $Instructors
 *
 * @method \App\Model\Entity\InstructorInsuranceForm get($primaryKey, $options = [])
 * @method \App\Model\Entity\InstructorInsuranceForm newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InstructorInsuranceForm[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InstructorInsuranceForm|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InstructorInsuranceForm|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InstructorInsuranceForm patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InstructorInsuranceForm[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InstructorInsuranceForm findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InstructorInsuranceFormsTable extends Table
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

        $this->setTable('instructor_insurance_forms');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Instructors', [
            'foreignKey' => 'instructor_id',
            'joinType' => 'INNER'
        ]);
        // $config = [
        //         'document_name' => [
        //         'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForInstructorsForms'),
        //         'fields' => [
        //             'dir' => 'document_path'
        //         ],
        //         'nameCallback' => function ($data, $settings) {
        //             return time(). $data['name'];
        //             },
        //         ],
        //     ];
        // //  $this->addBehavior('Josegonzalez/Upload.Upload', [
        // //   'document_name' => [
        // //     'path' => Configure::read('ImageUpload.uploadPathForInstructorsForms'),
        // //     'fields' => [
        // //       'dir' => 'document_path'
        // //     ],
        // //     'nameCallback' => function ($data, $settings) {
        // //       return time(). $data['name'];
        // //     },
        // //   ],
        // // ]);
        // if(Configure::read('uploadSetting') === 's3'){
        //     $config['document_name']['path'] = Configure::read('ImageUpload.uploadPathForInstructorsForms'); 
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
            ->allowEmpty('document_name');

        $validator
            ->scalar('document_path')
            // ->maxLength('document_path', 255)
            // ->requirePresence('document_path', 'create')
            ->allowEmpty('document_path');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

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

        return $rules;
    }
    public function beforeMarshal($event, $data, $options){
        if(isset($data['document_name'])){
        if(gettype($data['document_name']) == 'array'){
            $config = [
                'document_name' => [
                'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForInstructorsForms'),
                'fields' => [
                    'dir' => 'document_path'
                ],
                'nameCallback' => function ($data, $settings) {
                    return time(). $data['name'];
                    },
                ],
        ];
        if(Configure::read('uploadSetting') === 's3'){
            $config['document_name']['path'] = Configure::read('ImageUpload.uploadPathForInstructorsForms');
            $config['document_name']['filesystem'] = [
                    'adapter' => Configure::read('Josegonzalez/upload'),
                ];
        }
        $this->addBehavior('Josegonzalez/Upload.Upload', $config);
        }
    }
    }
}
