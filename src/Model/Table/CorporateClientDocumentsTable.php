<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Text;
use App\Model\Entity\CorporateClientDocument;
use Cake\Core\Configure;

/**
 * CorporateClientDocuments Model
 *
 * @property \App\Model\Table\CorporateClientsTable|\Cake\ORM\Association\BelongsTo $CorporateClients
 *
 * @method \App\Model\Entity\CorporateClientDocument get($primaryKey, $options = [])
 * @method \App\Model\Entity\CorporateClientDocument newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CorporateClientDocument[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CorporateClientDocument|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CorporateClientDocument|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CorporateClientDocument patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CorporateClientDocument[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CorporateClientDocument findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CorporateClientDocumentsTable extends Table
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

        $this->setTable('corporate_client_documents');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CorporateClients', [
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
            // ->scalar('document_name')
            // ->maxLength('document_name', 255)
            ->allowEmpty('document_name');

        $validator
            ->scalar('document_path')
            // ->maxLength('document_path', 255)
            ->allowEmpty('document_path');

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
        $rules->add($rules->existsIn(['corporate_client_id'], 'CorporateClients'));

        return $rules;
    }
    public function beforeMarshal($event, $data, $options){
        if(isset($data['document_name'])){
        if(gettype($data['document_name']) == 'array'){
            $config = [
                'document_name' => [
                'path' => Configure::read('App.webroot').Configure::read('ImageUpload.uploadPathForCorporateClientDocuments'),
                'fields' => [
                    'dir' => 'document_path'
                ],
                'nameCallback' => function ($data, $settings) {
                    return time(). $data['name'];
                    },
                ],
        ];
        if(Configure::read('uploadSetting') === 's3'){
            
            $config['document_name']['path'] = Configure::read('ImageUpload.uploadPathForCorporateClientDocuments'); 
            $config['document_name']['filesystem'] = [
                    'adapter' => Configure::read('Josegonzalez/upload'),
                ];
        }
        $this->addBehavior('Josegonzalez/Upload.Upload', $config);
        }
    }
    }
}
