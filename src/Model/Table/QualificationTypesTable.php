<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * QualificationTypes Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Qualifications
 * @property \App\Model\Table\InstructorQualificationsTable|\Cake\ORM\Association\HasMany $InstructorQualifications
 *
 * @method \App\Model\Entity\QualificationType get($primaryKey, $options = [])
 * @method \App\Model\Entity\QualificationType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\QualificationType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\QualificationType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QualificationType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\QualificationType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\QualificationType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\QualificationType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class QualificationTypesTable extends Table
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

        $this->setTable('qualification_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Qualifications', [
            'foreignKey' => 'qualification_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('InstructorQualifications', [
            'foreignKey' => 'qualification_type_id'
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
            ->notEmpty('name');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['qualification_id'], 'Qualifications'));

        return $rules;
    }
}
