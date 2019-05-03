<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CorporateClientResetPasswordHash Entity
 *
 * @property int $id
 * @property int $corporate_client_user_id
 * @property string $hash
 * @property string $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\CorporateClientUser $corporate_client_user
 */
class CorporateClientResetPasswordHash extends Entity
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
        'corporate_client_user_id' => true,
        'hash' => true,
        'created' => true,
        'modified' => true,
        'corporate_client_user' => true
    ];
}
