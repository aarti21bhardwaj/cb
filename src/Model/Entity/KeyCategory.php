<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * KeyCategory Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property string $name
 * @property string $description
 * @property bool $status
 *
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Addon[] $addons
 * @property \App\Model\Entity\Key[] $keys
 */
class KeyCategory extends Entity
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
        'tenant' => true,
        'addons' => true,
        'keys' => true
    ];
}
