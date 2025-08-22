<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CashMovement Entity
 *
 * @property int $id
 * @property int $cash_box_id
 * @property string|null $type
 * @property string $montant
 * @property string $motif
 * @property int $user_id
 * @property string|null $justificatif
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int $create_uid
 * @property string $uuid
 *
 * @property \App\Model\Entity\CashBox $cash_box
 * @property \App\Model\Entity\User $user
 */
class CashMovement extends Entity
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
        'cash_box_id' => true,
        'type' => true,
        'montant' => true,
        'motif' => true,
        'user_id' => true,
        'justificatif' => true,
        'created' => true,
        'modified' => true,
        'create_uid' => true,
        'uuid' => true,
        'cash_box' => true,
        'user' => true,
    ];
}
