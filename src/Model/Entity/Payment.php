<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property int $transaction_id
 * @property int $student_id
 * @property int $tenant_id
 * @property string $payment_status
 * @property int $order_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $amount
 *
 * @property \App\Model\Entity\Transaction $transaction
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Order $order
 */
class Payment extends Entity
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
        'transaction_id' => true,
        'student_id' => true,
        'tenant_id' => true,
        'payment_status' => true,
        'order_id' => true,
        'created' => true,
        'modified' => true,
        'amount' => true,
        'transaction' => true,
        'student' => true,
        'tenant' => true,
        'order' => true
    ];
}
