<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CardPrintingProfileTrainingSite Entity
 *
 * @property int $id
 * @property int $card_printing_profile_id
 * @property int $training_site_id
 *
 * @property \App\Model\Entity\CardPrintingProfile $card_printing_profile
 * @property \App\Model\Entity\TrainingSite $training_site
 */
class CardPrintingProfileTrainingSite extends Entity
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
        'card_printing_profile_id' => true,
        'training_site_id' => true,
        'card_printing_profile' => true,
        'training_site' => true,
        'tenant_id' => true

    ];
}
