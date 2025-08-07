<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShortcutsFixture
 */
class ShortcutsFixture extends TestFixture
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
                'url' => 'Lorem ipsum dolor sit amet',
                'shorturl' => 'Lorem ipsum dolor sit amet',
                'uuid' => 'Lorem ipsum dolor sit amet',
                'created' => 1740499494,
                'modified' => 1740499494,
                'create_uid' => 1,
                'write_uid' => 1,
            ],
        ];
        parent::init();
    }
}
