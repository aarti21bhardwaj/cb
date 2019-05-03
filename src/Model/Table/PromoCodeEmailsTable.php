<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PromoCodeEmails Model
 *
 * @property \App\Model\Table\PromoCodesTable|\Cake\ORM\Association\BelongsTo $PromoCodes
 *
 * @method \App\Model\Entity\PromoCodeEmail get($primaryKey, $options = [])
 * @method \App\Model\Entity\PromoCodeEmail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PromoCodeEmail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PromoCodeEmail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PromoCodeEmail|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PromoCodeEmail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PromoCodeEmail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PromoCodeEmail findOrCreate($search, callable $callback = null, $options = [])
 */
class PromoCodeEmailsTable extends Table
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

        $this->setTable('promo_code_emails');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PromoCodes', [
            'foreignKey' => 'promo_code_id',
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

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
        $rules->add($rules->existsIn(['promo_code_id'], 'PromoCodes'));

        return $rules;
    }
}
