<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TextClip Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property string $name
 * @property string $description
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Tenant $tenant
 */
class TextClip extends Entity
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
        'tenant_id' => true,
        'name' => true,
        'description' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'tenant' => true
    ];
}
