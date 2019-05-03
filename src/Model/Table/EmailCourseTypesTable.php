<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailCourseTypes Model
 *
 * @property \App\Model\Table\EmailsTable|\Cake\ORM\Association\BelongsTo $Emails
 * @property \App\Model\Table\CourseTypesTable|\Cake\ORM\Association\BelongsTo $CourseTypes
 *
 * @method \App\Model\Entity\EmailCourseType get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailCourseType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmailCourseType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailCourseType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailCourseType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailCourseType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailCourseType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailCourseType findOrCreate($search, callable $callback = null, $options = [])
 */
class EmailCourseTypesTable extends Table
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

        $this->setTable('email_course_types');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Emails', [
            'foreignKey' => 'email_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CourseTypes', [
            'foreignKey' => 'course_type_id',
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
        $rules->add($rules->existsIn(['email_id'], 'Emails'));
        $rules->add($rules->existsIn(['course_type_id'], 'CourseTypes'));

        return $rules;
    }
}
