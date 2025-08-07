<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateInspections extends BaseMigration
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
        $table = $this->table('inspections');
        $table->addColumn('name', 'string', ['limit' => 255, 'null' => false])
              ->addColumn('customer_id', 'integer', ['null' => false])
              ->addColumn('gender_id', 'integer', ['null' => false])
              ->addColumn('status', 'string', ['limit' => 10, 'null' => false])
              ->addColumn('end_date', 'datetime', ['null' => false])
              ->addColumn('created', 'datetime', ['null' => false])
              ->addColumn('create_uid', 'integer', ['null' => false])
              ->addColumn('modified', 'datetime', ['null' => false])
              ->addColumn('write_uid', 'integer', ['null' => false])
              ->addColumn('uuid', 'string', ['limit' => 36, 'null' => false])
         ->create();
    }
}
