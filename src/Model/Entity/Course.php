<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Core\Configure;


/**
 * Course Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $location_id
 * @property int $training_site_id
 * @property int $corporate_client_id
 * @property int $course_type_category_id
 * @property int $course_type_id
 * @property string $duration
 * @property bool $private_course
 * @property string $pay_structure
 * @property string $instructor_pay
 * @property string $additional_pay
 * @property string $additional_notes
 * @property int $seats
 * @property string $cost
 * @property string $class_details
 * @property string $instructor_notes
 * @property string $admin_notes
 * @property string $av_provided_by
 * @property string $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string $display_type
 * @property string $private_course_url
 * @property $document_name
 * @property string $document_path
 * @property string $notes
 * @property bool $private_course_flag
 *
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\TrainingSite $training_site
 * @property \App\Model\Entity\CorporateClient $corporate_client
 * @property \App\Model\Entity\CourseTypeCategory $course_type_category
 * @property \App\Model\Entity\CourseType $course_type
 * @property \App\Model\Entity\CourseAddon[] $course_addons
 * @property \App\Model\Entity\CourseDate[] $course_dates
 * @property \App\Model\Entity\CourseDisplayType[] $course_display_types
 * @property \App\Model\Entity\CourseDocument[] $course_documents
 * @property \App\Model\Entity\CourseInstructor[] $course_instructors
 * @property \App\Model\Entity\CourseStudent[] $course_students
 */
class Course extends Entity
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
        'location_id' => true,
        'training_site_id' => true,
        'corporate_client_id' => true,
        'course_type_category_id' => true,
        'course_type_id' => true,
        'duration' => true,
        'private_course' => true,
        'pay_structure' => true,
        'instructor_pay' => true,
        'additional_pay' => true,
        'additional_notes' => true,
        'seats' => true,
        'cost' => true,
        'class_details' => true,
        'instructor_notes' => true,
        'admin_notes' => true,
        'av_provided_by' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'display_type' => true,
        'private_course_url' => true,
        'document_name' => true,
        'document_path' => true,
        'notes' => true,
        'private_course_flag' => true,
        'tenant' => true,
        'location' => true,
        'training_site' => true,
        'corporate_client' => true,
        'course_type_category' => true,
        'course_type' => true,
        'course_addons' => true,
        'course_dates' => true,
        'course_display_types' => true,
        'course_documents' => true,
        'course_instructors' => true,
        'course_students' => true,
        'instructor_bidding' => true,
        'bidding_number' => true,
        'full' => true,
        'added_by' => true,
        'owner_id' => true
    ];

    protected $_virtual = ['image_url'];
    protected function _getImageUrl()
    {
        // pr('here in model');
        // pr($this->_property['expiry_date']);die;
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
}
