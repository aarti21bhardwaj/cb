<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InstructorReferences Model
 *
 * @property \App\Model\Table\InstructorsTable|\Cake\ORM\Association\BelongsTo $Instructors
 *
 * @method \App\Model\Entity\InstructorReference get($primaryKey, $options = [])
 * @method \App\Model\Entity\InstructorReference newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InstructorReference[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InstructorReference|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InstructorReference|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InstructorReference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InstructorReference[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InstructorReference findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InstructorReferencesTable extends Table
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

        $this->setTable('instructor_references');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Instructors', [
            'foreignKey' => 'instructor_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->allowEmpty('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->allowEmpty('email');

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 255)
            ->requirePresence('phone_number', 'create')
            ->allowEmpty('phone_number');

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
        $rules->add($rules->existsIn(['instructor_id'], 'Instructors'));

        return $rules;
    }
}
