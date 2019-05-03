<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\Schema\TableSchema;


/**
 * IndexSettings Model
 *
 * @property \App\Model\Table\ForsTable|\Cake\ORM\Association\BelongsTo $Fors
 *
 * @method \App\Model\Entity\IndexSetting get($primaryKey, $options = [])
 * @method \App\Model\Entity\IndexSetting newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IndexSetting[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IndexSetting|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IndexSetting|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IndexSetting patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IndexSetting[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IndexSetting findOrCreate($search, callable $callback = null, $options = [])
 */
class IndexSettingsTable extends Table
{


    protected function _initializeSchema(TableSchema $schema)
    {
        $schema->setColumnType('meta', 'json');

        return $schema;
    }
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('index_settings');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        // $this->belongsTo('index_settings', [
        //     'foreignKey' => 'for_id',
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
            ->integer('for_id')
            ->allowEmpty('for_id', 'create');

        $validator
            ->scalar('for_name')
            ->maxLength('for_name', 255)
            ->requirePresence('for_name', 'create')
            ->notEmpty('for_name');

        $validator
            // ->scalar('meta')
            ->requirePresence('meta', 'create')
            ->notEmpty('meta');

        $validator
            ->scalar('index_name')
            ->maxLength('index_name', 255)
            ->requirePresence('index_name', 'create')
            ->notEmpty('index_name');

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
        // $rules->add($rules->existsIn(['for_id'], 'index_settings'));
        $rules->add($rules->isUnique(['for_id','index_name']));


        return $rules;
    }

    public function beforeMarshal($event, $entity, $options) {

        // $entity['meta'] = json_encode($entity['meta']);
    }

}
