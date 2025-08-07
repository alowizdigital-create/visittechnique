<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateMessages extends BaseMigration
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
        $table = $this->table('messages');
        $table
            ->addColumn('sender_name', 'string', ['limit' => 11])
            ->addColumn('receiver', 'string', ['limit' => 10, 'collation' => 'utf8mb4_0900_ai_ci'])
            ->addColumn('content', 'text')
            ->addColumn('created', 'datetime')
            ->addColumn('create_uid', 'integer')
            ->addColumn('modified', 'datetime')
            ->addColumn('write_uid', 'integer')
            ->addColumn('uuid', 'string', ['limit' => 40])
            ->addColumn('status', 'string', ['limit' => 10])
            ->addColumn('sent_date', 'datetime')
            ->addColumn('response_code', 'integer')
            ->addColumn('response_body', 'text')
            ->addColumn('parts', 'integer')
            ->addColumn('inspection_id', 'integer', ['default' => 0])
            ->addColumn('customer_id', 'integer')
            ->addColumn('direction', 'string', ['limit' => 3, 'default' => 'out'])
        ->create();
    }
}
