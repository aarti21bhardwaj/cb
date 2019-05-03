<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Routing\Router;

/**
 * Student Entity
 *
 * @property int $id
 * @property int $training_site_id
 * @property int $tenant_id
 * @property int $corporate_client_id
 * @property string $subcontracted_client_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $phone1
 * @property string $phone2
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $role_id
 * @property string $student_profession
 * @property string $hear_about_us
 * @property string $health_care_provider
 * @property string $requested_organisation
 * @property string $comments
 *
 * @property \App\Model\Entity\TrainingSite $training_site
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\CorporateClient $corporate_client
 * @property \App\Model\Entity\SubcontractedClient $subcontracted_client
 * @property \App\Model\Entity\CourseStudent[] $course_students
 */
class Student extends Entity
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
        'tenant_id' => true,
        'corporate_client_id' => true,
        'subcontracted_client_id' => true,
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'password' => true,
        'address' => true,
        'city' => true,
        'state' => true,
        'zipcode' => true,
        'phone1' => true,
        'phone2' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'role_id' => true,
        'student_profession' => true,
        'hear_about_us' => true,
        'health_care_provider' => true,
        'requested_organisation' => true,
        'comments' => true,
        'training_site' => true,
        'role' => true,
        'tenant' => true,
        'corporate_client' => true,
        'subcontracted_client' => true,
        'course_students' => true,
        'others' => true,
        'line_items' => true
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
}
