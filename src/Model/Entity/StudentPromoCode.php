<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StudentPromoCode Entity
 *
 * @property int $id
 * @property int $student_id
 * @property int $promo_code_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $applied_by
 * @property int|null $course_id
 *
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\PromoCode $promo_code
 */
class StudentPromoCode extends Entity
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
        'promo_code_id' => true,
        'created' => true,
        'modified' => true,
        'applied_by' => true,
        'course_id' => true,
        'student' => true,
        'promo_code' => true
    ];
}
