<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SubcontractedClients Model
 *
 * @property \App\Model\Table\TrainingSitesTable|\Cake\ORM\Association\BelongsTo $TrainingSites
 * @property \App\Model\Table\CorporateClientsTable|\Cake\ORM\Association\BelongsTo $CorporateClients
 * @property \App\Model\Table\StudentsTable|\Cake\ORM\Association\HasMany $Students
 *
 * @method \App\Model\Entity\SubcontractedClient get($primaryKey, $options = [])
 * @method \App\Model\Entity\SubcontractedClient newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SubcontractedClient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SubcontractedClient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SubcontractedClient|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SubcontractedClient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SubcontractedClient[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SubcontractedClient findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubcontractedClientsTable extends Table
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

        $this->setTable('subcontracted_clients');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('TrainingSites', [
            'foreignKey' => 'training_site_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CorporateClients', [
            'foreignKey' => 'corporate_client_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Students', [
            'foreignKey' => 'subcontracted_client_id'
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
            ->scalar('address')
            ->allowEmpty('address');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->requirePresence('city', 'create')
            ->notEmpty('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 255)
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->scalar('zipcode')
            ->maxLength('zipcode', 255)
            ->requirePresence('zipcode', 'create')
            ->notEmpty('zipcode');

        $validator
            ->scalar('contact_name')
            ->maxLength('contact_name', 255)
            ->requirePresence('contact_name', 'create')
            ->notEmpty('contact_name');

        $validator
            ->scalar('contact_phone')
            ->maxLength('contact_phone', 255)
            ->requirePresence('contact_phone', 'create')
            ->notEmpty('contact_phone');

        $validator
            ->scalar('contact_email')
            ->maxLength('contact_email', 255)
            ->requirePresence('contact_email', 'create')
            ->notEmpty('contact_email');

        $validator
            ->boolean('web_page')
            ->requirePresence('web_page', 'create')
            ->notEmpty('web_page');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('web_url')
            ->maxLength('web_url', 255)
            ->allowEmpty('web_url');

        $validator
            ->scalar('web_id')
            ->maxLength('web_id', 255)
            ->allowEmpty('web_id');

        $validator
            ->scalar('subcontractedclient_detail')
            ->maxLength('subcontractedclient_detail', 255)
            ->allowEmpty('subcontractedclient_detail');

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
        $rules->add($rules->existsIn(['training_site_id'], 'TrainingSites'));
        $rules->add($rules->existsIn(['corporate_client_id'], 'CorporateClients'));

        return $rules;
    }
}