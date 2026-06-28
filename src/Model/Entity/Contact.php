<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Contact Entity
 *
 * @property int $id
 * @property string $name
 * @property string $firstname
 * @property string $phone
 * @property string $email
 * @property \Cake\I18n\DateTime $created
 * @property int $create_uid
 * @property \Cake\I18n\DateTime $modified
 * @property int $write_uid
 * @property string $uuid
 *
 * @property \App\Model\Entity\Message[] $messages
 * @property \App\Model\Entity\Team[] $teams
 */
class Contact extends Entity
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
        'firstname' => true,
        'phone' => true,
        'email' => true,
        'created' => true,
        'create_uid' => true,
        'modified' => true,
        'write_uid' => true,
        'uuid' => true,
        'messages' => true,
        'teams' => true,
    ];
}
