<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TransferCourse Entity
 *
 * @property int $id
 * @property int $course_id
 * @property int $tenant_id
 * @property int $assigning_tenant_id
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $assigner_uuid
 *
 * @property \App\Model\Entity\Course $course
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\AssigningTenant $assigning_tenant
 */
class TransferCourse extends Entity
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
        'course_id' => true,
        'tenant_id' => true,
        'assigning_tenant_id' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'assignee_uuid' => true,
        'course' => true,
        'tenant' => true,
        'assigning_tenant' => true,
        'access_revoked' => true
    ];
}
