<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Addons Model
 *
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\KeyCategoriesTable|\Cake\ORM\Association\BelongsTo $KeyCategories
 * @property \App\Model\Table\CourseAddonsTable|\Cake\ORM\Association\HasMany $CourseAddons
 *
 * @method \App\Model\Entity\Addon get($primaryKey, $options = [])
 * @method \App\Model\Entity\Addon newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Addon[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Addon|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Addon|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Addon patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Addon[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Addon findOrCreate($search, callable $callback = null, $options = [])
 */
class AddonsTable extends Table
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

        $this->setTable('addons');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('KeyCategories', [
            'foreignKey' => 'key_category_id'
        ]);
        $this->hasMany('CourseAddons', [
            'foreignKey' => 'addon_id'
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
            ->scalar('product_code')
            ->maxLength('product_code', 255)
            ->requirePresence('product_code', 'create')
            ->notEmpty('product_code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->scalar('short_description')
            ->requirePresence('short_description', 'create')
            ->notEmpty('short_description');

        $validator
            ->scalar('price')
            ->maxLength('price', 255)
            ->requirePresence('price', 'create')
            ->notEmpty('price');

        $validator
            ->boolean('option_status')
            ->requirePresence('option_status', 'create')
            ->notEmpty('option_status');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->allowEmpty('type');

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
        $rules->add($rules->existsIn(['key_category_id'], 'KeyCategories'));

        return $rules;
    }
}
