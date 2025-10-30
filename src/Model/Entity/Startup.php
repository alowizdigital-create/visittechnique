<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Startup Entity
 *
 * @property int $id
 * @property string $name
 * @property int $create_uid
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property string $uuid
 * @property string $phone
 * @property string $mail
 * @property string $logo
 *
 * @property \App\Model\Entity\Account[] $accounts
 * @property \App\Model\Entity\Admin[] $admins
 * @property \App\Model\Entity\Customer[] $customers
 * @property \App\Model\Entity\Gender[] $genders
 * @property \App\Model\Entity\Motif[] $motifs
 * @property \App\Model\Entity\User[] $users
 */
class Startup extends Entity
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
        'create_uid' => true,
        'created' => true,
        'modified' => true,
        'uuid' => true,
        'phone' => true,
        'mail' => true,
        'logo' => true,
        'accounts' => true,
        'admins' => true,
        'customers' => true,
        'genders' => true,
        'motifs' => true,
        'users' => true,
    ];
}
