<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MotifsFixture
 */
class MotifsFixture extends TestFixture
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
                'content' => 1,
                'create_uid' => 1,
                'created' => '2025-09-03 04:09:17',
                'modified' => '2025-09-03 04:09:17',
                'uuid' => 'Lorem ipsum dolor sit amet',
                'startup_id' => 1,
            ],
        ];
        parent::init();
    }
}
