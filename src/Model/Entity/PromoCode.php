<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PromoCode Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property string $code
 * @property string $description
 * @property \Cake\I18n\FrozenDate $start_date
 * @property \Cake\I18n\FrozenDate $end_date
 * @property string $discount_type
 * @property int $discount
 * @property int $no_of_uses
 * @property bool $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $subcontracted_client_id
 * @property int $corporate_client_id
 * @property bool $restrict_by_course_types
 * @property bool $restrict_by_email
 *
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\SubcontractedClient $subcontracted_client
 * @property \App\Model\Entity\CorporateClient $corporate_client
 * @property \App\Model\Entity\PromoCodeCourseType[] $promo_code_course_types
 * @property \App\Model\Entity\PromoCodeEmail[] $promo_code_emails
 * @property \App\Model\Entity\CourseType[] $course_types
 */
class PromoCode extends Entity
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
        'code' => true,
        'description' => true,
        'start_date' => true,
        'end_date' => true,
        'discount_type' => true,
        'discount' => true,
        'no_of_uses' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'subcontracted_client_id' => true,
        'corporate_client_id' => true,
        'restrict_by_course_types' => true,
        'restrict_by_email' => true,
        'tenant' => true,
        'subcontracted_client' => true,
        'corporate_client' => true,
        'promo_code_course_types' => true,
        'promo_code_emails' => true,
        'course_types' => true
    ];
}
