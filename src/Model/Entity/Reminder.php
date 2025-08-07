<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reminder Entity
 *
 * @property int $id
 * @property int $gender_id
 * @property int $template_id
 * @property int $date_before1
 * @property int $date_before2
 * @property int $date_before3
 * @property int $date_before4
 * @property int $days_after
 * @property \Cake\I18n\DateTime $created
 * @property int $create_uid
 * @property \Cake\I18n\DateTime $modified
 * @property int $write_uid
 * @property string $uuid
 *
 * @property \App\Model\Entity\Gender $gender
 * @property \App\Model\Entity\Template $template
 */
class Reminder extends Entity
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
        'name' => true,
        'gender_id' => true,
        'template_id' => true,
        'date_before1' => true,
        'date_before2' => true,
        'date_before3' => true,
        'date_before4' => true,
        'days_after' => true,
        'created' => true,
        'create_uid' => true,
        'modified' => true,
        'write_uid' => true,
        'uuid' => true,
        'gender' => true,
        'template' => true,
    ];
}
