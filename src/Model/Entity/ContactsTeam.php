<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContactsTeam Entity
 *
 * @property int $id
 * @property int $contact_id
 * @property int $team_id
 *
 * @property \App\Model\Entity\Contact $contact
 * @property \App\Model\Entity\Team $team
 */
class ContactsTeam extends Entity
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
        'contact_id' => true,
        'team_id' => true,
        'contact' => true,
        'team' => true,
    ];
}
