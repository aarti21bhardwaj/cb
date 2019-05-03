<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Core\Configure;


/**
 * InstructorInsuranceForm Entity
 *
 * @property int $id
 * @property int $instructor_id
 * @property $document_name
 * @property string $document_path
 * @property \Cake\I18n\FrozenDate $date
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Instructor $instructor
 */
class InstructorInsuranceForm extends Entity
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
        'instructor_id' => true,
        'document_name' => true,
        'document_path' => true,
        'date' => true,
        'created' => true,
        'modified' => true,
        'instructor' => true
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
