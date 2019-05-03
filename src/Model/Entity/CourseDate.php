<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CourseDate Entity
 *
 * @property int $id
 * @property int $course_id
 * @property \Cake\I18n\FrozenDate|null $course_date
 * @property \Cake\I18n\FrozenTime|null $time_from
 * @property \Cake\I18n\FrozenTime|null $time_to
 *
 * @property \App\Model\Entity\Course $course
 */
class CourseDate extends Entity
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
        'course_date' => true,
        'time_from' => true,
        'time_to' => true,
        'course' => true
    ];
}
