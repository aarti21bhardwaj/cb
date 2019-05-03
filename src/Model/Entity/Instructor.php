<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Routing\Router;
use Cake\Core\Configure;


/**
 * Instructor Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $training_site_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property $image_name
 * @property string $image_path
 * @property string $phone_1
 * @property string $phone_2
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $role_id
 *
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\TrainingSite $training_site
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\CourseInstructor[] $course_instructors
 */
class Instructor extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'password' => true,
        'image_name' => true,
        'image_path' => true,
        'phone_1' => true,
        'phone_2' => true,
        'address' => true,
        'city' => true,
        'state' => true,
        'zipcode' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'role_id' => true,
        'tenant' => true,
        'training_site' => true,
        'role' => true,
        'course_instructors' => true,
        'delete_at' => true,
        'token' => true,
        'is_verified' => true,
        'lat' => true,
        'lng' => true


    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($value){
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($value);    
    }

    protected $_virtual = ['image_url'];
    protected function _getImageUr1l()
    {
         $url = Router::url('/img/pdficon.png',true);
        if(!is_string($this->document_name))
        {
            return $url;
        }    
        // pr($this->_properties);die;
        if(isset($this->document_name) && !empty($this->document_name)) {
            $url = Configure::read('fileUpload').$this->document_path.'/'.$this->document_name;
            return $url;
        }


    }

    //  protected function _getImageUrl() { 
    //     if(isset($this->_properties['image_name']) && !empty($this->_properties['image_name'])) 
    //     { //pr($this->_properties['image_name']); die();
    //      $url = Router::url('/instructors_images/'.$this->_properties['image_name'],true); 
    //      // pr($url); die('ss');
    //     }else{
    //         $url = Router::url('/img/default-img.jpeg',true);
    //     }
    //     return $url; 
    // }
}