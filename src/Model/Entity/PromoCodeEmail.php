<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PromoCodeEmail Entity
 *
 * @property int $id
 * @property int $promo_code_id
 * @property string $email
 *
 * @property \App\Model\Entity\PromoCode $promo_code
 */
class PromoCodeEmail extends Entity
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
        'email' => true,
        'promo_code' => true
    ];
}
