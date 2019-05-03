<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TenantConfigSetting Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property bool $card_print
 * @property bool $instructor_bidding
 * @property bool $sandbox
 * @property string $payment_mode
 * @property string $stripe_test_published_key
 * @property string $stripe_test_private_key
 * @property string $stripe_live_published_key
 * @property string $stripe_live_private_key
 * @property string $termcondition
 * @property string $hear_about
 * @property bool $course_description
 * @property bool $location_notes
 * @property bool $class_details
 * @property bool $remaining_seats
 * @property bool $promocode
 * @property string $API_enpoint
 * @property string $API_username
 * @property string $API_password
 * @property string $API_signature
 * @property string $API_paypal_url
 * @property string $authorize_API_url_sandbox
 * @property string $authorize_login_id_sandbox
 * @property string $authorize_transaction_key_sandbox
 * @property string $authorize_API_url_live
 * @property string $authorize_login_id_live
 * @property string $authorize_transaction_key_live
 * @property string $intuit_login_id_sandbox
 * @property string $intuit_key_sandbox
 * @property string $intuit_login_id_live
 * @property string $intuit_key_live
 *
 * @property \App\Model\Entity\Tenant $tenant
 */
class TenantConfigSetting extends Entity
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
        'card_print' => true,
        'instructor_bidding' => true,
        'sandbox' => true,
        'payment_mode' => true,
        'stripe_test_published_key' => true,
        'stripe_test_private_key' => true,
        'stripe_live_published_key' => true,
        'stripe_live_private_key' => true,
        'termcondition' => true,
        'hear_about' => true,
        'course_description' => true,
        'location_notes' => true,
        'class_details' => true,
        'remaining_seats' => true,
        'promocode' => true,
        'API_enpoint' => true,
        'API_username' => true,
        'API_password' => true,
        'API_signature' => true,
        'API_paypal_url' => true,
        'authorize_API_url_sandbox' => true,
        'authorize_login_id_sandbox' => true,
        'authorize_transaction_key_sandbox' => true,
        'authorize_API_url_live' => true,
        'authorize_login_id_live' => true,
        'authorize_transaction_key_live' => true,
        'intuit_login_id_sandbox' => true,
        'intuit_key_sandbox' => true,
        'intuit_login_id_live' => true,
        'intuit_key_live' => true,
        'tenant' => true
    ];
}
