<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * VehiclesFixture
 */
class VehiclesFixture extends TestFixture
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
                'customer_id' => 1,
                'registration_number' => 'Lorem ipsum dolor ',
                'brand' => 'Lorem ipsum dolor sit amet',
                'model' => 'Lorem ipsum dolor sit amet',
                'year' => 1,
                'type' => 'Lorem ipsum dolor ',
                'weight' => 1.5,
                'created' => '2025-07-11 10:58:20',
                'create_uid' => 1,
                'modified' => '2025-07-11 10:58:20',
                'write_uid' => 1,
                'uuid' => 'a505f876-fb41-449f-a14e-818979b90849',
            ],
        ];
        parent::init();
    }
}
