<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CashMovementsFixture
 */
class CashMovementsFixture extends TestFixture
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
                'cash_box_id' => 1,
                'type' => 'Lorem ipsum dolor sit amet',
                'montant' => 1.5,
                'motif' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'user_id' => 1,
                'justificatif' => 'Lorem ipsum dolor sit amet',
                'created' => '2025-08-12 02:16:44',
                'modified' => '2025-08-12 02:16:44',
                'create_uid' => 1,
                'uuid' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
