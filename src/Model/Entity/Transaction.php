<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaction Entity
 *
 * @property int $id
 * @property string $charge_id
 * @property string $payment_method
 * @property string $amount
 * @property string $remark
 * @property bool $status
 * @property string $type
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $parent_id
 * @property int|null $available_amount
 *
 * @property \App\Model\Entity\Charge $charge
 * @property \App\Model\Entity\Transaction $parent_transaction
 * @property \App\Model\Entity\Payment[] $payments
 * @property \App\Model\Entity\Transaction[] $child_transactions
 */
class Transaction extends Entity
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
        'charge_id' => true,
        'payment_method' => true,
        'amount' => true,
        'remark' => true,
        'status' => true,
        'type' => true,
        'created' => true,
        'modified' => true,
        'parent_id' => true,
        'available_amount' => true,
        'charge' => true,
        'parent_transaction' => true,
        'payments' => true,
        'child_transactions' => true
    ];
}
