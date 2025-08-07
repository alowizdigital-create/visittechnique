<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateCustomers extends BaseMigration
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
        $table = $this->table('customers');
        $table
            ->addColumn('name', 'string', ['limit' => 100])
            ->addColumn('phone', 'string', ['limit' => 20])
            ->addColumn('email', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('address', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created', 'datetime')
            ->addColumn('create_uid', 'integer')
            ->addColumn('modified', 'datetime')
            ->addColumn('write_uid', 'integer')
            ->addColumn('uuid', 'uuid')
        ->create();
    }
}
