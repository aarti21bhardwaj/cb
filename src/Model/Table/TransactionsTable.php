<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transactions Model
 *
 * @property \App\Model\Table\ChargesTable|\Cake\ORM\Association\BelongsTo $Charges
 * @property \App\Model\Table\TransactionsTable|\Cake\ORM\Association\BelongsTo $ParentTransactions
 * @property \App\Model\Table\PaymentsTable|\Cake\ORM\Association\HasMany $Payments
 * @property \App\Model\Table\TransactionsTable|\Cake\ORM\Association\HasMany $ChildTransactions
 *
 * @method \App\Model\Entity\Transaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\Transaction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Transaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transaction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transaction|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Transaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Transaction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transaction findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TransactionsTable extends Table
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

        $this->setTable('transactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Charges', [
            'foreignKey' => 'charge_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ParentTransactions', [
            'className' => 'Transactions',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'transaction_id'
        ]);
        // $this->hasMany('ChildTransactions', [
        //     'className' => 'Transactions',
        //     'foreignKey' => 'parent_id'
        // ]);
         $this->belongsTo('Refunds', [
            'className' => 'Transactions',
            'foreignKey' =>'parent_id', 
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
            ->scalar('payment_method')
            ->maxLength('payment_method', 255)
            ->requirePresence('payment_method', 'create')
            ->notEmpty('payment_method');

        $validator
            ->scalar('amount')
            ->maxLength('amount', 255)
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->scalar('remark')
            ->maxLength('remark', 255)
            ->requirePresence('remark', 'create')
            ->notEmpty('remark');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->integer('available_amount')
            ->allowEmpty('available_amount');

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
        // $rules->add($rules->existsIn(['charge_id'], 'Charges'));
        // $rules->add($rules->existsIn(['parent_id'], 'Transactions'));

        return $rules;
    }
}
