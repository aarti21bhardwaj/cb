<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailRecipients Model
 *
 * @property \App\Model\Table\EmailsTable|\Cake\ORM\Association\BelongsTo $Emails
 * @property \App\Model\Table\CorporateClientsTable|\Cake\ORM\Association\BelongsTo $CorporateClients
 * @property \App\Model\Table\SubcontractedClientsTable|\Cake\ORM\Association\BelongsTo $SubcontractedClients
 *
 * @method \App\Model\Entity\EmailRecipient get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmailRecipient newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmailRecipient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmailRecipient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailRecipient|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmailRecipient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmailRecipient[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmailRecipient findOrCreate($search, callable $callback = null, $options = [])
 */
class EmailRecipientsTable extends Table
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

        $this->setTable('email_recipients');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Emails', [
            'foreignKey' => 'email_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CorporateClients', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->belongsTo('SubcontractedClients', [
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
            ->scalar('email_send_to')
            ->maxLength('email_send_to', 255)
            ->allowEmpty('email_send_to');

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
        $rules->add($rules->existsIn(['email_id'], 'Emails'));
        $rules->add($rules->existsIn(['corporate_client_id'], 'CorporateClients'));
        $rules->add($rules->existsIn(['subcontracted_client_id'], 'SubcontractedClients'));

        return $rules;
    }
}
