<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Discount Entity
 *
 * @property int $id
 * @property string $amount
 * @property int $gender_id
 * @property string|null $note
 * @property \Cake\I18n\DateTime $created
 * @property int $create_uid
 * @property \Cake\I18n\DateTime $modified
 * @property int $write_uid
 * @property string $uuid
 *
 * @property \App\Model\Entity\Gender $gender
 */
class Discount extends Entity
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
        'amount' => true,
        'note' => true,
        'created' => true,
        'create_uid' => true,
        'modified' => true,
        'write_uid' => true,
        'uuid' => true,
        'gender' => true,
    ];
}
