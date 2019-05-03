<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailConfiguration Entity
 *
 * @property int $id
 * @property int $email_id
 * @property int $schedule
 * @property string $recipient
 *
 * @property \App\Model\Entity\Email $email
 */
class EmailConfiguration extends Entity
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
        'email_id' => true,
        'schedule' => true,
        'recipient' => true,
        'email' => true
    ];
}
