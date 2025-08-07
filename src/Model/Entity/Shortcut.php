<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shortcut Entity
 *
 * @property int $id
 * @property string $url
 * @property string $shorturl
 * @property string $uuid
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property int $create_uid
 * @property int $write_uid
 */
class Shortcut extends Entity
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
        'url' => true,
        'shorturl' => true,
        'uuid' => true,
        'created' => true,
        'modified' => true,
        'create_uid' => true,
        'write_uid' => true,
    ];
}
