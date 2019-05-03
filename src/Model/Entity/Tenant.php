<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Core\Configure;

/**
 * Tenant Entity
 *
 * @property int $id
 * @property string $center_name
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $domain_type
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property $image_name
 * @property string $image_path
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Addon[] $addons
 * @property \App\Model\Entity\CorporateClient[] $corporate_clients
 * @property \App\Model\Entity\CourseTypeCategory[] $course_type_categories
 * @property \App\Model\Entity\Course[] $courses
 * @property \App\Model\Entity\Instructor[] $instructors
 * @property \App\Model\Entity\KeyCategory[] $key_categories
 * @property \App\Model\Entity\Location[] $locations
 * @property \App\Model\Entity\TenantOldPassword[] $tenant_old_passwords
 * @property \App\Model\Entity\TenantSetting[] $tenant_settings
 * @property \App\Model\Entity\TenantUser[] $tenant_users
 * @property \App\Model\Entity\TrainingSite[] $training_sites
 * @property \App\Model\Entity\TextClip[] $text_clips
 */
class Tenant extends Entity
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
        'center_name' => true,
        'address' => true,
        'city' => true,
        'state' => true,
        'zip' => true,
        'domain_type' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'image_name' => true,
        'image_path' => true,
        'role' => true,
        'addons' => true,
        'corporate_clients' => true,
        'course_type_categories' => true,
        'courses' => true,
        'instructors' => true,
        'key_categories' => true,
        'locations' => true,
        'tenant_old_passwords' => true,
        'tenant_settings' => true,
        'tenant_users' => true,
        'tenant_config_settings' => true,
        'tenant_themes' => true,
        'training_sites' => true,
        'text_clips' => true,
        'uuid' =>  true,
        'email' => true
    ];
    protected $_virtual = ['image_url'];
    protected function _getImageUrl() { 
        $url = Router::url('/img/default-img.jpeg',true);
        if(!is_string($this->image_name))
        {
            return $url;
        }    
         if(isset($this->image_name) && !empty($this->image_name)) {
            $url = Configure::read('fileUpload').$this->image_path.'/'.$this->image_name;
            return $url;
        }   
    }
}
