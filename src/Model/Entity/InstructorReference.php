<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InstructorReference Entity
 *
 * @property int $id
 * @property int $instructor_id
 * @property string $name
 * @property string $email
 * @property string $phone_number
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Instructor $instructor
 */
class InstructorReference extends Entity
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
        'name' => true,
        'email' => true,
        'phone_number' => true,
        'created' => true,
        'modified' => true,
        'instructor' => true
    ];
}
