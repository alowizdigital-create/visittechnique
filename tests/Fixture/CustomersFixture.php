<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CustomersFixture
 */
class CustomersFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'phone' => 'Lorem ipsum dolor ',
                'email' => 'Lorem ipsum dolor sit amet',
                'address' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-07-11 07:42:33',
                'create_uid' => 1,
                'modified' => '2025-07-11 07:42:33',
                'write_uid' => 1,
                'uuid' => '75709eb7-b081-4940-8eb1-b5e1fd7f7ff9',
            ],
        ];
        parent::init();
    }
}
