<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StudentTransferHistories Model
 *
 * @property \App\Model\Table\StudentsTable|\Cake\ORM\Association\BelongsTo $Students
 * @property \App\Model\Table\PreviousCoursesTable|\Cake\ORM\Association\BelongsTo $PreviousCourses
 * @property \App\Model\Table\CurrentCoursesTable|\Cake\ORM\Association\BelongsTo $CurrentCourses
 *
 * @method \App\Model\Entity\StudentTransferHistory get($primaryKey, $options = [])
 * @method \App\Model\Entity\StudentTransferHistory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StudentTransferHistory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StudentTransferHistory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentTransferHistory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentTransferHistory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StudentTransferHistory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StudentTransferHistory findOrCreate($search, callable $callback = null, $options = [])
 */
class StudentTransferHistoriesTable extends Table
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

        $this->setTable('student_transfer_histories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PreviousCourses', [
            'className' => 'Courses',
            'foreignKey' => 'previous_course_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CurrentCourses', [
            'className' => 'Courses',
            'foreignKey' => 'current_course_id',
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
            ->date('transfer_date')
            ->requirePresence('transfer_date', 'create')
            ->notEmpty('transfer_date');

        $validator
            ->integer('additional_amount')
            ->allowEmpty('additional_amount');

        $validator
            ->integer('refund_amount')
            ->allowEmpty('refund_amount');

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
        $rules->add($rules->existsIn(['student_id'], 'Students'));
        $rules->add($rules->existsIn(['previous_course_id'], 'PreviousCourses'));
        $rules->add($rules->existsIn(['current_course_id'], 'CurrentCourses'));

        return $rules;
    }
}
