<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CardPrintingProfileTrainingSites Model
 *
 * @property \App\Model\Table\CardPrintingProfilesTable|\Cake\ORM\Association\BelongsTo $CardPrintingProfiles
 * @property \App\Model\Table\TrainingSitesTable|\Cake\ORM\Association\BelongsTo $TrainingSites
 *
 * @method \App\Model\Entity\CardPrintingProfileTrainingSite get($primaryKey, $options = [])
 * @method \App\Model\Entity\CardPrintingProfileTrainingSite newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CardPrintingProfileTrainingSite[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CardPrintingProfileTrainingSite|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CardPrintingProfileTrainingSite|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CardPrintingProfileTrainingSite patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CardPrintingProfileTrainingSite[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CardPrintingProfileTrainingSite findOrCreate($search, callable $callback = null, $options = [])
 */
class CardPrintingProfileTrainingSitesTable extends Table
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

        $this->setTable('card_printing_profile_training_sites');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('CardPrintingProfiles', [
            'foreignKey' => 'card_printing_profile_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('TrainingSites', [
            'foreignKey' => 'training_site_id',
            'joinType' => 'INNER'
        ]);
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
        $rules->add($rules->existsIn(['card_printing_profile_id'], 'CardPrintingProfiles'));
        $rules->add($rules->existsIn(['training_site_id'], 'TrainingSites'));

        return $rules;
    }
}
