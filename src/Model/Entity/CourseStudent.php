<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CourseStudent Entity
 *
 * @property int $id
 * @property int $course_id
 * @property int $student_id
 * @property int $course_status
 * @property string $payment_status
 * @property int $test_score
 * @property int $skills
 * @property \Cake\I18n\FrozenTime $registration_date
 * @property \Cake\I18n\FrozenTime $cancellation_date
 *
 * @property \App\Model\Entity\Course $course
 * @property \App\Model\Entity\Student $student
 */
class CourseStudent extends Entity
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
        'student_id' => true,
        'course_status' => true,
        'payment_status' => true,
        'test_score' => true,
        'skills' => true,
        'registration_date' => true,
        'cancellation_date' => true,
        'course' => true,
        'student' => true
    ];
}
