<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Collection\Collection;

/**
 * TenantSettings Model
 *
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 *
 * @method \App\Model\Entity\TenantSetting get($primaryKey, $options = [])
 * @method \App\Model\Entity\TenantSetting newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TenantSetting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TenantSetting|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TenantSetting|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TenantSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TenantSetting[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TenantSetting findOrCreate($search, callable $callback = null, $options = [])
 */
class TenantSettingsTable extends Table
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

        $this->setTable('tenant_settings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
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
            ->boolean('enable_training_site_module')
            ->requirePresence('enable_training_site_module', 'create')
            ->notEmpty('enable_training_site_module');

        $validator
            ->boolean('enable_corporate_module')
            ->requirePresence('enable_corporate_module', 'create')
            ->notEmpty('enable_corporate_module');

        $validator
            ->boolean('enable_aed_pm_module')
            ->requirePresence('enable_aed_pm_module', 'create')
            ->notEmpty('enable_aed_pm_module');

        $validator
            ->boolean('shop_menu_visible')
            ->requirePresence('shop_menu_visible', 'create')
            ->notEmpty('shop_menu_visible');

        $validator
            ->scalar('default_theme')
            ->maxLength('default_theme', 255)
            // ->requirePresence('default_theme', 'create')
            ->allowEmpty('default_theme');

        $validator
            ->boolean('key_management')
            ->requirePresence('key_management', 'create')
            ->notEmpty('key_management');

        $validator
            ->scalar('admin_email')
            ->maxLength('admin_email', 255)
            // ->requirePresence('admin_email', 'create')
            ->allowEmpty('admin_email');

        $validator
            ->scalar('from_email')
            ->maxLength('from_email', 255)
            // ->requirePresence('from_email', 'create')
            ->allowEmpty('from_email');

        $validator
            ->boolean('allow_duplicate_emails')
            ->requirePresence('allow_duplicate_emails', 'create')
            ->notEmpty('allow_duplicate_emails');

        $validator
            ->scalar('training_centre_website')
            ->maxLength('training_centre_website', 255)
            // ->requirePresence('training_centre_website', 'create')
            ->allowEmpty('training_centre_website');

        $validator
            ->scalar('bcc_email')
            ->maxLength('bcc_email', 255)
            // ->requirePresence('bcc_email', 'create')
            ->allowEmpty('bcc_email');

        $validator
            ->scalar('title_bar_text')
            ->maxLength('title_bar_text', 255)
            // ->requirePresence('title_bar_text', 'create')
            ->allowEmpty('title_bar_text');

        $validator
            ->boolean('enable_payment_email')
            ->requirePresence('enable_payment_email', 'create')
            ->notEmpty('enable_payment_email');

        $validator
            ->scalar('aed_pm_module_url')
            ->maxLength('aed_pm_module_url', 255);

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
   public function afterSave($event,$entity, $options){
        $this->Emails = TableRegistry::get('Emails');
        $updateEmails = $this->Emails->findByTenantId($entity->tenant_id)
                                ->where(['OR'=>['from_email' => '','from_email' => null]])
                                ->map(function($value,$key)use($entity){
                                    $value->from_email = $entity->from_email;
                                    return $value->toArray();
                                    })
                                ->toArray();
       
        $emails = $this->Emails->findByTenantId($entity->tenant_id)
                                ->where(['from_email' => ''])
                                ->toArray();
        $emails = $this->Emails->newEntities($emails);                        
        if(isset($updateEmails) && !empty($updateEmails)){
            // die('here');
            $entities = $this->Emails->patchEntities($emails,$updateEmails);
            if(!$this->Emails->saveMany($entities)){
            //        throw new NotFoundException(__('Emails Data not Changed'));
             }
        }
    }
}
