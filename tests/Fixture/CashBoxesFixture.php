<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CashBoxesFixture
 */
class CashBoxesFixture extends TestFixture
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
                'solde_initial' => 1.5,
                'solde_actuel' => 1.5,
                'statut' => 'Lorem ipsum dolor sit amet',
                'responsable_id' => 1,
                'created' => '2025-08-12 02:15:21',
                'modified' => '2025-08-12 02:15:21',
                'create_uid' => 1,
                'uuid' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
