<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'firstname' => 'Lorem ipsum dolor sit amet',
                'lastname' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'verified' => 1,
                'phone' => 1,
                'created' => '2025-05-27 02:40:57',
                'create_uid' => 1,
                'modified' => '2025-05-27 02:40:57',
                'write_uid' => 1,
                'uuid' => '40b16396-7e3f-42ee-ac8a-3c60cae8e36e',
            ],
        ];
        parent::init();
    }
}
