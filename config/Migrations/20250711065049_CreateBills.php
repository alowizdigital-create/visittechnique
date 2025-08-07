<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateBills extends BaseMigration
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
        $table = $this->table('bills');
        $table->addColumn('number', 'string',['limit'=>50]) 
                ->addColumn('amount', 'string', ['limit' => 50])
                 ->addColumn('payment_id', 'integer')
                ->addColumn('note', 'text', ['null' => true])
                ->addColumn('created', 'datetime')
                ->addColumn('create_uid', 'integer')
                ->addColumn('modified', 'datetime')
                ->addColumn('write_uid', 'integer')
                ->addColumn('uuid', 'char', ['limit' => 36])
        ->create();
    }
}
