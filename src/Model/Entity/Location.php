<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Location Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $training_site_id
 * @property int $corporate_client_id
 * @property string $name
 * @property string $contact_name
 * @property string|null $contact_email
 * @property string $contact_phone
 * @property string|null $address
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property float|null $lat
 * @property float|null $lng
 * @property string|null $notes
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\TrainingSite $training_site
 * @property \App\Model\Entity\CorporateClient $corporate_client
 * @property \App\Model\Entity\Course[] $courses
 */
class Location extends Entity
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
        'tenant_id' => true,
        'training_site_id' => true,
        'corporate_client_id' => true,
        'name' => true,
        'contact_name' => true,
        'contact_email' => true,
        'contact_phone' => true,
        'address' => true,
        'city' => true,
        'state' => true,
        'zipcode' => true,
        'lat' => true,
        'lng' => true,
        'notes' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'tenant' => true,
        'training_site' => true,
        'corporate_client' => true,
        'courses' => true
    ];
}
