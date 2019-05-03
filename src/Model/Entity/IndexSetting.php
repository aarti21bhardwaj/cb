<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IndexSetting Entity
 *
 * @property int $id
 * @property int $for_id
 * @property string $for_name
 * @property string $meta
 * @property string $index_name
 *
 * @property \App\Model\Entity\For $for
 */
class IndexSetting extends Entity
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
        'for_id' => true,
        'for_name' => true,
        'meta' => true,
        'index_name' => true
        // 'for' => true
    ];
}
