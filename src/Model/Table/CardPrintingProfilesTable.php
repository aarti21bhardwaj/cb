<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CardPrintingProfiles Model
 *
 * @property \App\Model\Table\CardPrintingProfileTrainingSitesTable|\Cake\ORM\Association\HasMany $CardPrintingProfileTrainingSites
 *
 * @method \App\Model\Entity\CardPrintingProfile get($primaryKey, $options = [])
 * @method \App\Model\Entity\CardPrintingProfile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CardPrintingProfile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CardPrintingProfile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CardPrintingProfile|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CardPrintingProfile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CardPrintingProfile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CardPrintingProfile findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CardPrintingProfilesTable extends Table
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

        $this->setTable('card_printing_profiles');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CardPrintingProfileTrainingSites', [
            'foreignKey' => 'card_printing_profile_id'
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
            ->integer('left_right_adjustment')
            ->allowEmpty('left_right_adjustment');

        $validator
            ->integer('up_down_adjustment')
            ->allowEmpty('up_down_adjustment');

        $validator
            ->boolean('status')
            ->allowEmpty('status');

        return $validator;
    }
}
