<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CourseTypes Model
 *
 * @property \App\Model\Table\CourseTypeCategoriesTable|\Cake\ORM\Association\BelongsTo $CourseTypeCategories
 * @property \App\Model\Table\AgenciesTable|\Cake\ORM\Association\BelongsTo $Agencies
 * @property |\Cake\ORM\Association\HasMany $CourseInstructors
 * @property \App\Model\Table\CourseTypeQualificationsTable|\Cake\ORM\Association\HasMany $CourseTypeQualifications
 * @property \App\Model\Table\CoursesTable|\Cake\ORM\Association\HasMany $Courses
 * @property |\Cake\ORM\Association\HasMany $EmailCourseTypes
 * @property \App\Model\Table\PromoCodeCourseTypesTable|\Cake\ORM\Association\HasMany $PromoCodeCourseTypes
 *
 * @method \App\Model\Entity\CourseType get($primaryKey, $options = [])
 * @method \App\Model\Entity\CourseType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CourseType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CourseType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CourseType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CourseType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CourseType findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CourseTypesTable extends Table
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

        $this->setTable('course_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('CourseTypeCategories', [
            'foreignKey' => 'course_type_category_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Agencies', [
            'foreignKey' => 'agency_id',
            'joinType' => 'LEFT'
        ]);
        $this->hasMany('CourseInstructors', [
            'foreignKey' => 'course_type_id'
        ]);
        $this->hasMany('CourseTypeQualifications', [
            'foreignKey' => 'course_type_id'
        ]);
        $this->hasMany('Courses', [
            'foreignKey' => 'course_type_id'
        ]);
        $this->hasMany('EmailCourseTypes', [
            'foreignKey' => 'course_type_id'
        ]);
        $this->hasMany('PromoCodeCourseTypes', [
            'foreignKey' => 'course_type_id'
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
            ->scalar('course_code')
            ->maxLength('course_code', 255)
            ->allowEmpty('course_code');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('valid_for')
            ->maxLength('valid_for', 255)
            ->allowEmpty('valid_for');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->scalar('class_detail')
            ->allowEmpty('class_detail');

        $validator
            ->scalar('notes_to_instructor')
            ->allowEmpty('notes_to_instructor');

        $validator
            ->scalar('color_code')
            ->maxLength('color_code', 255)
            ->allowEmpty('color_code');

        $validator
            ->boolean('status')
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['course_type_category_id'], 'CourseTypeCategories'));
        $rules->add($rules->existsIn(['agency_id'], 'Agencies'));

        return $rules;
    }
}
