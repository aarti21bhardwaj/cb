<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseTypeQualifications Model
 *
 * @property \App\Model\Table\CourseTypesTable|\Cake\ORM\Association\BelongsTo $CourseTypes
 * @property \App\Model\Table\QualificationsTable|\Cake\ORM\Association\BelongsTo $Qualifications
 *
 * @method \App\Model\Entity\CourseTypeQualification get($primaryKey, $options = [])
 * @method \App\Model\Entity\CourseTypeQualification newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CourseTypeQualification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CourseTypeQualification|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseTypeQualification|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseTypeQualification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CourseTypeQualification[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CourseTypeQualification findOrCreate($search, callable $callback = null, $options = [])
 */
class CourseTypeQualificationsTable extends Table
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

        $this->setTable('course_type_qualifications');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CourseTypes', [
            'foreignKey' => 'course_type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Qualifications', [
            'foreignKey' => 'qualification_id',
            'joinType' => 'INNER'
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
        $rules->add($rules->existsIn(['course_type_id'], 'CourseTypes'));
        $rules->add($rules->existsIn(['qualification_id'], 'Qualifications'));

        return $rules;
    }
}
