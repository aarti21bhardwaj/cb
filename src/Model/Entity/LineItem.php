<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LineItem Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int $addon_id
 * @property string $type
 * @property int $course_id
 * @property string $amount
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\Addon $addon
 * @property \App\Model\Entity\Course $course
 */
class LineItem extends Entity
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
        'order_id' => true,
        'addon_id' => true,
        'type' => true,
        'course_id' => true,
        'amount' => true,
        'created' => true,
        'modified' => true,
        'order' => true,
        'addon' => true,
        'student_id' => true,
        'course' => true
    ];
}
