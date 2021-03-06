<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseTypeCategories Model
 *
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\CourseTypesTable|\Cake\ORM\Association\HasMany $CourseTypes
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 *
 * @method \App\Model\Entity\CourseTypeCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\CourseTypeCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CourseTypeCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CourseTypeCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseTypeCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseTypeCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CourseTypeCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CourseTypeCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class CourseTypeCategoriesTable extends Table
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

        $this->setTable('course_type_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('CourseTypes', [
            'foreignKey' => 'course_type_category_id',
            'saveStrategy' => 'replace',
            'dependent' => true,
            'cascadeCallback' => true
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'course_type_category_id'
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
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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

        return $rules;
    }
}
