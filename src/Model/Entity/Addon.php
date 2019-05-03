<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Addon Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property string $product_code
 * @property string $name
 * @property string $description
 * @property string $short_description
 * @property string $price
 * @property bool $option_status
 * @property string $type
 * @property int $key_category_id
 *
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\KeyCategory $key_category
 * @property \App\Model\Entity\CourseAddon[] $course_addons
 */
class Addon extends Entity
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
        'product_code' => true,
        'name' => true,
        'description' => true,
        'short_description' => true,
        'price' => true,
        'option_status' => true,
        'type' => true,
        'key_category_id' => true,
        'tenant' => true,
        'key_category' => true,
        'course_addons' => true
    ];
}
