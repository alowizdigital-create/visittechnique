<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateVehicles extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('vehicles');
        $table
        ->addColumn('customer_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ])
        ->addColumn('registration_number', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ])
        ->addColumn('brand', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
        ])
        ->addColumn('model', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
        ])
        ->addColumn('year', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ])
        ->addColumn('type', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => false,
        ])
        ->addColumn('weight', 'decimal', [
            'default' => null,
            'null' => false,
            'precision' => 10,
            'scale' => 2,
        ])
        ->addColumn('created', 'datetime')
        ->addColumn('create_uid', 'integer')
        ->addColumn('modified', 'datetime')
        ->addColumn('write_uid', 'integer')
        ->addColumn('uuid', 'uuid')
        ->create();
    }
}
