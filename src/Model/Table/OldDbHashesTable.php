<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OldDbHashes Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Olds
 * @property |\Cake\ORM\Association\BelongsTo $News
 *
 * @method \App\Model\Entity\OldDbHash get($primaryKey, $options = [])
 * @method \App\Model\Entity\OldDbHash newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OldDbHash[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OldDbHash|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OldDbHash|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OldDbHash patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OldDbHash[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OldDbHash findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OldDbHashesTable extends Table
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

        $this->setTable('old_db_hashes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // $this->belongsTo('Olds', [
        //     'foreignKey' => 'old_id',
        //     'joinType' => 'INNER'
        // ]);
        // $this->belongsTo('News', [
        //     'foreignKey' => 'new_id',
        //     'joinType' => 'INNER'
        // ]);
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

            ->scalar('old_id')
            ->maxLength('old_id', 255)
            ->requirePresence('old_id', 'create')
            ->notEmpty('old_id');

        $validator
            ->scalar('new_id')
            ->maxLength('new_id', 255)
            ->requirePresence('new_id', 'create')
            ->notEmpty('new_id');

        $validator
            ->scalar('new_name')
            ->maxLength('new_name', 255)
            ->requirePresence('new_name', 'create')
            ->notEmpty('new_name');

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
        // $rules->add($rules->existsIn(['old_id'], 'Olds'));
        // $rules->add($rules->existsIn(['new_id'], 'News'));

        return $rules;
    }
}
