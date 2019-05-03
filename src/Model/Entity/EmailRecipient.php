<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmailRecipient Entity
 *
 * @property int $id
 * @property int $email_id
 * @property int|null $corporate_client_id
 * @property int|null $subcontracted_client_id
 * @property string|null $email_send_to
 *
 * @property \App\Model\Entity\Email $email
 * @property \App\Model\Entity\CorporateClient $corporate_client
 * @property \App\Model\Entity\SubcontractedClient $subcontracted_client
 */
class EmailRecipient extends Entity
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
        'corporate_client_id' => true,
        'subcontracted_client_id' => true,
        'email_send_to' => true,
        'email' => true,
        'corporate_client' => true,
        'subcontracted_client' => true
    ];
}
