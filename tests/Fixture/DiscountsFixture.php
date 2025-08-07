<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DiscountsFixture
 */
class DiscountsFixture extends TestFixture
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
                'amount' => 'Lorem ipsum dolor sit amet',
                'gender_id' => 1,
                'note' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2025-07-11 07:58:36',
                'create_uid' => 1,
                'modified' => '2025-07-11 07:58:36',
                'write_uid' => 1,
                'uuid' => '3655702f-f9de-477b-9fe2-dc7818fc8d5d',
            ],
        ];
        parent::init();
    }
}
