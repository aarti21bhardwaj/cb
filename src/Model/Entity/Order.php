<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int|null $promo_code_id
 * @property string $total_amount
 * @property int $tenant_id
 * @property string|null $student_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\PromoCode $promo_code
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\LineItem[] $line_items
 * @property \App\Model\Entity\Payment[] $payments
 */
class Order extends Entity
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
        'promo_code_id' => true,
        'total_amount' => true,
        'tenant_id' => true,
        'student_id' => true,
        'created' => true,
        'modified' => true,
        'promo_code' => true,
        'tenant' => true,
        'student' => true,
        'line_items' => true,
        'payments' => true
    ];
}
