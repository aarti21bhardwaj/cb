<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Email Entity
 *
 * @property int $id
 * @property int $tenant_id
 * @property int $event_id
 * @property string $subject
 * @property string|null $from_name
 * @property string|null $from_email
 * @property string $body
 * @property bool $status
 * @property bool $use_system_email
 * @property int $schedule
 *
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Event $event
 * @property \App\Model\Entity\EmailConfiguration[] $email_configurations
 * @property \App\Model\Entity\EmailCourseType[] $email_course_types
 * @property \App\Model\Entity\EmailRecipient[] $email_recipients
 */
class Email extends Entity
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
        'event_id' => true,
        'subject' => true,
        'from_name' => true,
        'from_email' => true,
        'body' => true,
        'status' => true,
        'use_system_email' => true,
        'schedule' => true,
        'tenant' => true,
        'event' => true,
        'email_configurations' => true,
        'email_course_types' => true,
        'email_recipients' => true
    ];
}
