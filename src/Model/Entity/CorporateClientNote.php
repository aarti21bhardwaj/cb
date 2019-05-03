<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CorporateClientNote Entity
 *
 * @property int $id
 * @property int $corporate_client_id
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\CorporateClient $corporate_client
 */
class CorporateClientNote extends Entity
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
        'corporate_client_id' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'corporate_client' => true
    ];
}
