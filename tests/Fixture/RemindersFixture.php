<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RemindersFixture
 */
class RemindersFixture extends TestFixture
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
                'gender_id' => 1,
                'template_id' => 1,
                'date_before1' => 1,
                'date_before2' => 1,
                'date_before3' => 1,
                'date_before4' => 1,
                'days_after' => 1,
                'created' => '2025-07-11 08:00:07',
                'create_uid' => 1,
                'modified' => '2025-07-11 08:00:07',
                'write_uid' => 1,
                'uuid' => 'e5125c3d-bbd6-4b1c-a164-9ff6b9b18641',
            ],
        ];
        parent::init();
    }
}
