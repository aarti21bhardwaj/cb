<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseStudents Model
 *
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\BelongsTo $Courses
 * @property \App\Model\Table\StudentsTable|\Cake\ORM\Association\BelongsTo $Students
 *
 * @method \App\Model\Entity\CourseStudent get($primaryKey, $options = [])
 * @method \App\Model\Entity\CourseStudent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CourseStudent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CourseStudent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseStudent|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseStudent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CourseStudent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CourseStudent findOrCreate($search, callable $callback = null, $options = [])
 */
class CourseStudentsTable extends Table
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

        $this->setTable('course_students');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Courses', [
            'foreignKey' => 'course_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
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

        $validator
            ->integer('course_status')
            ->allowEmpty('course_status');

        $validator
            ->scalar('payment_status')
            ->maxLength('payment_status', 255)
            ->allowEmpty('payment_status');

        $validator
            ->integer('test_score')
            ->allowEmpty('test_score');

        $validator
            ->integer('skills')
            ->allowEmpty('skills');

        $validator
            ->dateTime('registration_date')
            ->allowEmpty('registration_date');

        $validator
            ->dateTime('cancellation_date')
            ->allowEmpty('cancellation_date');

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
        $rules->add($rules->existsIn(['course_id'], 'Courses'));
        $rules->add($rules->existsIn(['student_id'], 'Students'));

        return $rules;
    }
}
