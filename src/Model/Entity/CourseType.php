<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CourseType Entity
 *
 * @property int $id
 * @property string|null $course_code
 * @property int $course_type_category_id
 * @property int $agency_id
 * @property string $name
 * @property string|null $valid_for
 * @property string|null $description
 * @property string|null $class_detail
 * @property string|null $notes_to_instructor
 * @property string|null $color_code
 * @property bool|null $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\CourseTypeCategory $course_type_category
 * @property \App\Model\Entity\Agency $agency
 * @property \App\Model\Entity\CourseTypeQualification[] $course_type_qualifications
 * @property \App\Model\Entity\Course[] $courses
 * @property \App\Model\Entity\PromoCodeCourseType[] $promo_code_course_types
 */
class CourseType extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'course_code' => true,
        'course_type_category_id' => true,
        'agency_id' => true,
        'name' => true,
        'valid_for' => true,
        'description' => true,
        'class_detail' => true,
        'notes_to_instructor' => true,
        'color_code' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'course_type_category' => true,
        'agency' => true,
        'course_type_qualifications' => true,
        'courses' => true,
        'promo_code_course_types' => true
    ];
}
