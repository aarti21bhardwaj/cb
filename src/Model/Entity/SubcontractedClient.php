<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SubcontractedClient Entity
 *
 * @property int $id
 * @property int $training_site_id
 * @property int $corporate_client_id
 * @property string $name
 * @property string|null $address
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string|null $contact_name
 * @property string|null $contact_phone
 * @property string|null $contact_email
 * @property bool $web_page
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $web_url
 * @property string|null $subcontractedclient_detail
 * @property string|null $web_id
 *
 * @property \App\Model\Entity\TrainingSite $training_site
 * @property \App\Model\Entity\CorporateClient $corporate_client
 * @property \App\Model\Entity\Student[] $students
 */
class SubcontractedClient extends Entity
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
        'training_site_id' => true,
        'corporate_client_id' => true,
        'name' => true,
        'address' => true,
        'city' => true,
        'state' => true,
        'zipcode' => true,
        'contact_name' => true,
        'contact_phone' => true,
        'contact_email' => true,
        'web_page' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'web_url' => true,
        'subcontractedclient_detail' => true,
        'web_id' => true,
        'training_site' => true,
        'corporate_client' => true,
        'students' => true
    ];
}
