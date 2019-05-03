<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OldDbHash Entity
 *
 * @property int $id
 * @property string $old_id
 * @property int $new_id
 * @property string $old_name
 * @property string $new_name
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class OldDbHash extends Entity
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
        'old_id' => true,
        'new_id' => true,
        'old_name' => true,
        'new_name' => true,
        'created' => true,
        'modified' => true
    ];
}
