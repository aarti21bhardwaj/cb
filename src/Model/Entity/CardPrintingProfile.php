<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CardPrintingProfile Entity
 *
 * @property int $id
 * @property string $name
 * @property int $left_right_adjustment
 * @property int $up_down_adjustment
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\CardPrintingProfileTrainingSite[] $card_printing_profile_training_sites
 */
class CardPrintingProfile extends Entity
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
        'name' => true,
        'left_right_adjustment' => true,
        'up_down_adjustment' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'card_printing_profile_training_sites' => true
    ];
}
