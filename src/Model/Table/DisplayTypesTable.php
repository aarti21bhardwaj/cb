<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DisplayTypes Model
 *
 * @property \App\Model\Table\CourseDisplayTypesTable|\Cake\ORM\Association\HasMany $CourseDisplayTypes
 *
 * @method \App\Model\Entity\DisplayType get($primaryKey, $options = [])
 * @method \App\Model\Entity\DisplayType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DisplayType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DisplayType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DisplayType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DisplayType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DisplayType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DisplayType findOrCreate($search, callable $callback = null, $options = [])
 */
class DisplayTypesTable extends Table
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

        $this->setTable('display_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('CourseDisplayTypes', [
            'foreignKey' => 'display_type_id'
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
}
