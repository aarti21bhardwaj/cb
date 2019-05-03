<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StudentTransferHistory Entity
 *
 * @property int $id
 * @property int $student_id
 * @property int $previous_course_id
 * @property int $current_course_id
 * @property \Cake\I18n\FrozenDate $transfer_date
 * @property int|null $additional_amount
 * @property int|null $refund_amount
 *
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\PreviousCourse $previous_course
 * @property \App\Model\Entity\CurrentCourse $current_course
 */
class StudentTransferHistory extends Entity
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
        'student_id' => true,
        'previous_course_id' => true,
        'current_course_id' => true,
        'transfer_date' => true,
        'additional_amount' => true,
        'refund_amount' => true,
        'student' => true,
        'previous_course' => true,
        'current_course' => true
    ];
}
