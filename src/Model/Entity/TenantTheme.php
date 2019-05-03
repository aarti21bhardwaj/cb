<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use Cake\Core\Configure;


/**
 * TenantTheme Entity
 *
 * @property int $id
 * @property string $theme_color_light
 * @property string $theme_color_dark
 * @property string $logo_name
 * @property string $logo_path
 * @property string $content_area
 * @property string $content_sidebar
 * @property string $content_header
 * @property string $content_footer
 * @property string $redirect_url
 */
class TenantTheme extends Entity
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
        'theme_color_light' => true,
        'theme_color_dark' => true,
        'logo_name' => true,
        'logo_path' => true,
        'content_area' => true,
        'content_sidebar' => true,
        'content_header' => true,
        'content_footer' => true,
        'redirect_url' => true,
        'tenant_id' => true,
        'color' => true
    ];
    protected $_virtual = ['image_url'];
    protected function _getImageUrl() { 
        $url = Router::url('/img/default-img.jpeg',true);
        if(!is_string($this->log_name))
        {
            return $url;
        }    
         if(isset($this->logo_name) && !empty($this->logo_name)) {
            $url = Configure::read('fileUpload').$this->logo_path.'/'.$this->logo_name;
            return $url;
        } 
    }
}
