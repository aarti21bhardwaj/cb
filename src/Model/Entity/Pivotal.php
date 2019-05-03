<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pivotal Entity
 *
 * @property int $id
 * @property int $key_category_id
 * @property string $info
 *
 * @property \App\Model\Entity\KeyCategory $key_category
 */
class Pivotal extends Entity
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
        'key_category_id' => true,
        'info' => true,
        'key_category' => true
    ];
}
