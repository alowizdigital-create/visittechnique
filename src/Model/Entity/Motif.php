<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Motif Entity
 *
 * @property int $id
 * @property int $content
 * @property int $create_uid
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property string $uuid
 * @property int $startup_id
 *
 * @property \App\Model\Entity\Startup $startup
 * @property \App\Model\Entity\CashMovement[] $cash_movements
 */
class Motif extends Entity
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
        'content' => true,
        'create_uid' => true,
        'created' => true,
        'modified' => true,
        'uuid' => true,
        'startup_id' => true,
        'startup' => true,
        'cash_movements' => true,
    ];
}
