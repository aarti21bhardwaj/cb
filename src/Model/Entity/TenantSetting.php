<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TenantSetting Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property bool $enable_training_site_module
 * @property bool $enable_corporate_module
 * @property bool $enable_aed_pm_module
 * @property bool $shop_menu_visible
 * @property string $default_theme
 * @property bool $key_management
 * @property string $admin_email
 * @property string $from_email
 * @property bool $allow_duplicate_emails
 * @property string $training_centre_website
 * @property string $bcc_email
 * @property string $title_bar_text
 * @property bool $enable_payment_email
 *
 * @property \App\Model\Entity\Tenant $tenant
 */
class TenantSetting extends Entity
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
        'enable_training_site_module' => true,
        'enable_corporate_module' => true,
        'enable_aed_pm_module' => true,
        'shop_menu_visible' => true,
        'default_theme' => true,
        'key_management' => true,
        'admin_email' => true,
        'from_email' => true,
        'allow_duplicate_emails' => true,
        'training_centre_website' => true,
        'bcc_email' => true,
        'title_bar_text' => true,
        'enable_payment_email' => true,
        'tenant' => true,
        'aed_pm_module_url' => true
    ];
}
