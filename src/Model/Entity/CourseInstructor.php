<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CourseInstructor Entity
 *
 * @property int $id
 * @property int $course_id
 * @property int $instructor_id
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Course $course
 * @property \App\Model\Entity\Instructor $instructor
 */
class CourseInstructor extends Entity
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
        'course_id' => true,
        'instructor_id' => true,
        'location_id' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'course' => true,
        'instructor' => true,
        'instructor_pay' => true,
        'additional_pay' => true,
        'per_diem' => true,

    ];
}
