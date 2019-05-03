<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CorporateClients Model
 *
 * @property \App\Model\Table\UrlsTable|\Cake\ORM\Association\BelongsTo $Urls
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\TrainingSitesTable|\Cake\ORM\Association\BelongsTo $TrainingSites
 * @property \App\Model\Table\CorporateClientDocumentsTable|\Cake\ORM\Association\HasMany $CorporateClientDocuments
 * @property \App\Model\Table\CorporateClientNotesTable|\Cake\ORM\Association\HasMany $CorporateClientNotes
 * @property \App\Model\Table\CorporateClientUsersTable|\Cake\ORM\Association\HasMany $CorporateClientUsers
 * @property |\Cake\ORM\Association\HasMany $CourseInstructors
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 * @property \App\Model\Table\LocationsTable|\Cake\ORM\Association\HasMany $Locations
 * @property \App\Model\Table\PromoCodesTable|\Cake\ORM\Association\HasMany $PromoCodes
 * @property \App\Model\Table\StudentsTable|\Cake\ORM\Association\HasMany $Students
 * @property \App\Model\Table\SubcontractedClientsTable|\Cake\ORM\Association\HasMany $SubcontractedClients
 *
 * @method \App\Model\Entity\CorporateClient get($primaryKey, $options = [])
 * @method \App\Model\Entity\CorporateClient newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CorporateClient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CorporateClient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CorporateClient|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CorporateClient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CorporateClient[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CorporateClient findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CorporateClientsTable extends Table
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

        $this->setTable('corporate_clients');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Urls', [
            'foreignKey' => 'url_id'
        ]);
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TrainingSites', [
            'foreignKey' => 'training_site_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('CorporateClientDocuments', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->hasMany('CorporateClientNotes', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->hasMany('CorporateClientUsers', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->hasMany('CourseInstructors', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->hasMany('Locations', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->hasMany('PromoCodes', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->hasMany('Students', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->hasMany('SubcontractedClients', [
            'foreignKey' => 'corporate_client_id'
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
            ->boolean('web_page')
            ->requirePresence('web_page', 'create')
            ->notEmpty('web_page');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('corporate_details')
            ->allowEmpty('corporate_details');

        $validator
            ->scalar('web_url')
            ->maxLength('web_url', 255)
            ->allowEmpty('web_url');

        $validator
            ->scalar('web_id')
            ->maxLength('web_id', 255)
            ->allowEmpty('web_id');

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
        $rules->add($rules->existsIn(['training_site_id'], 'TrainingSites'));

        return $rules;
    }
}
