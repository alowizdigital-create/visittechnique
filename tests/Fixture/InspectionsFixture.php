<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * InspectionsFixture
 */
class InspectionsFixture extends TestFixture
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
                'customer_id' => 1,
                'gender_id' => 1,
                'status' => 'Lorem ip',
                'end_date' => '2025-07-11 07:43:07',
                'created' => '2025-07-11 07:43:07',
                'create_uid' => 1,
                'modified' => '2025-07-11 07:43:07',
                'write_uid' => 1,
                'uuid' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
