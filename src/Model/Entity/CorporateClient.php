<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CorporateClient Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $address
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property bool $web_page
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $url_id
 * @property string|null $corporate_details
 * @property int $tenant_id
 * @property int $training_site_id
 * @property string|null $web_url
 *
 * @property \App\Model\Entity\Url $url
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\TrainingSite $training_site
 * @property \App\Model\Entity\CorporateClientDocument[] $corporate_client_documents
 * @property \App\Model\Entity\CorporateClientNote[] $corporate_client_notes
 * @property \App\Model\Entity\CorporateClientUser[] $corporate_client_users
 * @property \App\Model\Entity\Course[] $courses
 * @property \App\Model\Entity\Location[] $locations
 * @property \App\Model\Entity\PromoCode[] $promo_codes
 * @property \App\Model\Entity\Student[] $students
 * @property \App\Model\Entity\SubcontractedClient[] $subcontracted_clients
 */
class CorporateClient extends Entity
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
        'address' => true,
        'city' => true,
        'state' => true,
        'zipcode' => true,
        'web_page' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'url_id' => true,
        'corporate_details' => true,
        'tenant_id' => true,
        'training_site_id' => true,
        'web_url' => true,
        'url' => true,
        'tenant' => true,
        'training_site' => true,
        'corporate_client_documents' => true,
        'corporate_client_notes' => true,
        'corporate_client_users' => true,
        'courses' => true,
        'locations' => true,
        'promo_codes' => true,
        'students' => true,
        'subcontracted_clients' => true
    ];
}
