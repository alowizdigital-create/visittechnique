<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StartupsFixture
 */
class StartupsFixture extends TestFixture
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
                'create_uid' => 1,
                'created' => 1756873733,
                'modified' => 1756873733,
                'uuid' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
