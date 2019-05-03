<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pivotals Model
 *
 * @property \App\Model\Table\KeyCategoriesTable|\Cake\ORM\Association\BelongsTo $KeyCategories
 *
 * @method \App\Model\Entity\Pivotal get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pivotal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pivotal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pivotal|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pivotal|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pivotal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pivotal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pivotal findOrCreate($search, callable $callback = null, $options = [])
 */
class PivotalsTable extends Table
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

        $this->setTable('pivotals');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('KeyCategories', [
            'foreignKey' => 'key_category_id',
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
            ->scalar('info')
            ->requirePresence('info', 'create')
            ->notEmpty('info');

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
        $rules->add($rules->existsIn(['key_category_id'], 'KeyCategories'));

        return $rules;
    }
}
