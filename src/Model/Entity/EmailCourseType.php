<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailCourseType Entity
 *
 * @property int $id
 * @property int $email_id
 * @property int $course_type_id
 *
 * @property \App\Model\Entity\Email $email
 * @property \App\Model\Entity\CourseType $course_type
 */
class EmailCourseType extends Entity
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
        'email_id' => true,
        'course_type_id' => true,
        'email' => true,
        'course_type' => true
    ];
}
