<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PromoCodes Model
 *
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\SubcontractedClientsTable|\Cake\ORM\Association\BelongsTo $SubcontractedClients
 * @property \App\Model\Table\CorporateClientsTable|\Cake\ORM\Association\BelongsTo $CorporateClients
 * @property \App\Model\Table\PromoCodeCourseTypesTable|\Cake\ORM\Association\HasMany $PromoCodeCourseTypes
 * @property \App\Model\Table\PromoCodeEmailsTable|\Cake\ORM\Association\HasMany $PromoCodeEmails
 *
 * @method \App\Model\Entity\PromoCode get($primaryKey, $options = [])
 * @method \App\Model\Entity\PromoCode newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PromoCode[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PromoCode|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PromoCode|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PromoCode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PromoCode[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PromoCode findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PromoCodesTable extends Table
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

        $this->setTable('promo_codes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('SubcontractedClients', [
            'foreignKey' => 'subcontracted_client_id'
        ]);
        $this->belongsTo('CorporateClients', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->hasMany('PromoCodeCourseTypes', [
            'foreignKey' => 'promo_code_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('PromoCodeEmails', [
            'foreignKey' => 'promo_code_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);

        $this->belongsToMany('CourseTypes', [
            'through' => 'PromoCodeCourseTypes'
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
            ->scalar('code')
            ->maxLength('code', 255)
            ->requirePresence('code', 'create')
            ->notEmpty('code');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->date('start_date')
            ->requirePresence('start_date', 'create')
            ->notEmpty('start_date');

        $validator
            ->date('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmpty('end_date');

        $validator
            ->scalar('discount_type')
            ->maxLength('discount_type', 255)
            ->requirePresence('discount_type', 'create')
            ->notEmpty('discount_type');

        $validator
            ->integer('discount')
            ->requirePresence('discount', 'create')
            ->notEmpty('discount');

        $validator
            ->integer('no_of_uses')
            ->requirePresence('no_of_uses', 'create')
            ->notEmpty('no_of_uses');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->boolean('restrict_by_course_types')
            ->allowEmpty('restrict_by_course_types');

        $validator
            ->boolean('restrict_by_email')
            ->allowEmpty('restrict_by_email');

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
        $rules->add($rules->existsIn(['subcontracted_client_id'], 'SubcontractedClients'));
        $rules->add($rules->existsIn(['corporate_client_id'], 'CorporateClients'));

        return $rules;
    }
}
