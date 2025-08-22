<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CashBox Entity
 *
 * @property int $id
 * @property string $name
 * @property string $solde_initial
 * @property string $solde_actuel
 * @property string $statut
 * @property int $responsable_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int $create_uid
 * @property string $uuid
 *
 * @property \App\Model\Entity\CashMovement[] $cash_movements
 */
class CashBox extends Entity
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
        'solde_initial' => true,
        'solde_actuel' => true,
        'cashinout' => true,
        'cashinput' => true,
        'statut' => true,
        'responsable_id' => true,
        'created' => true,
        'modified' => true,
        'create_uid' => true,
        'uuid' => true,
        'cash_movements' => true,
    ];
}
