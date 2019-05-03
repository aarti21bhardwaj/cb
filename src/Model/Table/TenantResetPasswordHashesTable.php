<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TenantResetPasswordHashes Model
 *
 * @property \App\Model\Table\TenantUsersTable|\Cake\ORM\Association\BelongsTo $TenantUsers
 *
 * @method \App\Model\Entity\TenantResetPasswordHash get($primaryKey, $options = [])
 * @method \App\Model\Entity\TenantResetPasswordHash newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TenantResetPasswordHash[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TenantResetPasswordHash|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TenantResetPasswordHash|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TenantResetPasswordHash patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TenantResetPasswordHash[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TenantResetPasswordHash findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TenantResetPasswordHashesTable extends Table
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

        $this->setTable('tenant_reset_password_hashes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('TenantUsers', [
            'foreignKey' => 'tenant_user_id',
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
            ->scalar('hash')
            ->maxLength('hash', 255)
            ->requirePresence('hash', 'create')
            ->notEmpty('hash');

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
        $rules->add($rules->existsIn(['tenant_user_id'], 'TenantUsers'));

        return $rules;
    }
}
