<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity
 *
 * @property int $id
 * @property string $sender_name
 * @property string $receiver
 * @property string $content
 * @property \Cake\I18n\DateTime $created
 * @property int $create_uid
 * @property \Cake\I18n\DateTime $modified
 * @property int $write_uid
 * @property string $uuid
 * @property string $status
 * @property \Cake\I18n\DateTime $sent_date
 * @property int $response_code
 * @property string $response_body
 * @property int $parts
 * @property int $inspection_id
 * @property int $customer_id
 * @property string $direction
 *
 * @property \App\Model\Entity\Inspection $inspection
 * @property \App\Model\Entity\Customer $customer
 */
class Message extends Entity
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
        'sender_name' => true,
        'receiver' => true,
        'content' => true,
        'created' => true,
        'create_uid' => true,
        'modified' => true,
        'write_uid' => true,
        'uuid' => true,
        'status' => true,
        'sent_date' => true,
        'response_code' => true,
        'response_body' => true,
        'parts' => true,
        'inspection_id' => true,
        'customer_id' => true,
        'direction' => true,
        'inspection' => true,
        'customer' => true,
    ];
}
