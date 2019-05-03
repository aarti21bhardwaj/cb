<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Core\Configure;

/**
 * TrainingSite Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property string $training_site_code
 * @property string $name
 * @property string $phone
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_phone
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property $site_contract_name
 * @property string $site_contract_path
 * @property \Cake\I18n\FrozenDate $site_contract_date
 * @property $site_monitoring_name
 * @property string $site_monitoring_path
 * @property \Cake\I18n\FrozenDate $site_monitoring_date
 * @property $site_insurance_name
 * @property string $site_insurance_path
 * @property \Cake\I18n\FrozenDate $site_insurance_expiry_date
 *
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\CorporateClient[] $corporate_clients
 * @property \App\Model\Entity\Course[] $courses
 * @property \App\Model\Entity\Instructor[] $instructors
 * @property \App\Model\Entity\Location[] $locations
 * @property \App\Model\Entity\TrainingSiteNote[] $training_site_notes
 */
class TrainingSite extends Entity
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
        'training_site_code' => true,
        'name' => true,
        'phone' => true,
        'address' => true,
        'city' => true,
        'state' => true,
        'zipcode' => true,
        'contact_name' => true,
        'contact_email' => true,
        'contact_phone' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'site_contract_name' => true,
        'site_contract_path' => true,
        'site_contract_date' => true,
        'site_monitoring_name' => true,
        'site_monitoring_path' => true,
        'site_monitoring_date' => true,
        'site_insurance_name' => true,
        'site_insurance_path' => true,
        'site_insurance_expiry_date' => true,
        'tenant' => true,
        'corporate_clients' => true,
        'courses' => true,
        'instructors' => true,
        'locations' => true,
        'training_site_notes' => true
    ];
    protected $_virtual = ['image_url'];
    protected function _getImageUrl()
    {
        // pr('here in model');
        // pr($this->_property['expiry_date']);die;
        $url = Router::url('/img/pdficon.png',true);
        if(!is_string($this->site_contract_name))
        {
            return $url;
        }    
        // pr($this->_properties);die;
        if(isset($this->site_contract_name) && !empty($this->site_contract_name)) {
            $url = Configure::read('fileUpload').$this->site_contract_name.'/'.$this->site_contract_path;
        return $url;
        }

        if(!is_string($this->site_insurance_name))
        {
            return $url;
        }    
        // pr($this->die;
        if(isset($this->site_insurance_name) && !empty($this->site_insurance_name)) {
            $url = Configure::read('fileUpload').$this->site_insurance_name.'/'.$this->site_insurance_path;
        return $url;
        }

        if(!is_string($this->site_monitoring_name))
        {
            return $url;
        }    
        // pr($this->die;
        if(isset($this->site_monitoring_name) && !empty($this->site_monitoring_name)) {
            $url = Configure::read('fileUpload').$this->site_monitoring_name.'/'.$this->site_monitoring_path;
        return $url;
        }

    }
}
