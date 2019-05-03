<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TenantConfigSettings Model
 *
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 *
 * @method \App\Model\Entity\TenantConfigSetting get($primaryKey, $options = [])
 * @method \App\Model\Entity\TenantConfigSetting newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TenantConfigSetting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TenantConfigSetting|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TenantConfigSetting|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TenantConfigSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TenantConfigSetting[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TenantConfigSetting findOrCreate($search, callable $callback = null, $options = [])
 */
class TenantConfigSettingsTable extends Table
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

        $this->setTable('tenant_config_settings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id'
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
            ->boolean('card_print')
            ->allowEmpty('card_print');

        $validator
            ->boolean('instructor_bidding')
            ->allowEmpty('instructor_bidding');

        $validator
            ->boolean('sandbox')
            ->allowEmpty('sandbox');

        $validator
            ->scalar('payment_mode')
            ->maxLength('payment_mode', 255)
            ->allowEmpty('payment_mode');

        $validator
            ->scalar('stripe_test_published_key')
            ->maxLength('stripe_test_published_key', 255)
            ->allowEmpty('stripe_test_published_key');

        $validator
            ->scalar('stripe_test_private_key')
            ->maxLength('stripe_test_private_key', 255)
            ->allowEmpty('stripe_test_private_key');

        $validator
            ->scalar('stripe_live_published_key')
            ->maxLength('stripe_live_published_key', 255)
            ->allowEmpty('stripe_live_published_key');

        $validator
            ->scalar('stripe_live_private_key')
            ->maxLength('stripe_live_private_key', 255)
            ->allowEmpty('stripe_live_private_key');

        $validator
            ->scalar('termcondition')
            ->allowEmpty('termcondition');

        $validator
            ->scalar('hear_about')
            ->allowEmpty('hear_about');

        $validator
            ->boolean('course_description')
            ->allowEmpty('course_description');

        $validator
            ->boolean('location_notes')
            ->allowEmpty('location_notes');

        $validator
            ->boolean('class_details')
            ->allowEmpty('class_details');

        $validator
            ->boolean('remaining_seats')
            ->allowEmpty('remaining_seats');

        $validator
            ->boolean('promocode')
            ->allowEmpty('promocode');

        $validator
            ->scalar('API_enpoint')
            ->maxLength('API_enpoint', 255)
            ->allowEmpty('API_enpoint');

        $validator
            ->scalar('API_username')
            ->maxLength('API_username', 255)
            ->allowEmpty('API_username');

        $validator
            ->scalar('API_password')
            ->maxLength('API_password', 255)
            ->allowEmpty('API_password');

        $validator
            ->scalar('API_signature')
            ->maxLength('API_signature', 255)
            ->allowEmpty('API_signature');

        $validator
            ->scalar('API_paypal_url')
            ->maxLength('API_paypal_url', 255)
            ->allowEmpty('API_paypal_url');

        $validator
            ->scalar('authorize_API_url_sandbox')
            ->maxLength('authorize_API_url_sandbox', 255)
            ->allowEmpty('authorize_API_url_sandbox');

        $validator
            ->scalar('authorize_login_id_sandbox')
            ->maxLength('authorize_login_id_sandbox', 255)
            ->allowEmpty('authorize_login_id_sandbox');

        $validator
            ->scalar('authorize_transaction_key_sandbox')
            ->maxLength('authorize_transaction_key_sandbox', 255)
            ->allowEmpty('authorize_transaction_key_sandbox');

        $validator
            ->scalar('authorize_API_url_live')
            ->maxLength('authorize_API_url_live', 255)
            ->allowEmpty('authorize_API_url_live');

        $validator
            ->scalar('authorize_login_id_live')
            ->maxLength('authorize_login_id_live', 255)
            ->allowEmpty('authorize_login_id_live');

        $validator
            ->scalar('authorize_transaction_key_live')
            ->maxLength('authorize_transaction_key_live', 255)
            ->allowEmpty('authorize_transaction_key_live');

        $validator
            ->scalar('intuit_login_id_sandbox')
            ->maxLength('intuit_login_id_sandbox', 255)
            ->allowEmpty('intuit_login_id_sandbox');

        $validator
            ->scalar('intuit_key_sandbox')
            ->maxLength('intuit_key_sandbox', 255)
            ->allowEmpty('intuit_key_sandbox');

        $validator
            ->scalar('intuit_login_id_live')
            ->maxLength('intuit_login_id_live', 255)
            ->allowEmpty('intuit_login_id_live');

        $validator
            ->scalar('intuit_key_live')
            ->maxLength('intuit_key_live', 255)
            ->allowEmpty('intuit_key_live');

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
        $rules->add($rules->existsIn(['tenant_id'], 'Tenants'));

        return $rules;
    }
}
