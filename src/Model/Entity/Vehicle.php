<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vehicle Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property string $registration_number
 * @property string $brand
 * @property string $model
 * @property int $year
 * @property string $type
 * @property string $weight
 * @property \Cake\I18n\DateTime $created
 * @property int $create_uid
 * @property \Cake\I18n\DateTime $modified
 * @property int $write_uid
 * @property string $uuid
 *
 * @property \App\Model\Entity\Customer $customer
 */
class Vehicle extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'customer_id' => true,
        'registration_number' => true,
        'brand' => true,
        'model' => true,
        'gender_id' => true,
        'weight' => true,
        'created' => true,
        'create_uid' => true,
        'modified' => true,
        'write_uid' => true,
        'uuid' => true,
        'customer' => true,
    ];
}
