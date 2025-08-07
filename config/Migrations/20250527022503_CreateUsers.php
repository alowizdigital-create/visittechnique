<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateUsers extends BaseMigration
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
        $table = $this->table('users');
        $table ->addColumn('firstname', 'string', ['limit' => 255])
                ->addColumn('lastname', 'string', ['limit' => 200])
                ->addColumn('email','string',['limit'=> 200])
                ->addColumn('password','string',['limit'=> 200])
                ->addColumn('myproject','string',['limit'=> 40])
                ->addColumn('is_active', 'boolean', ['default' => false])
                ->addColumn('token_expires', 'datetime', ['null' => false])
                ->addColumn('phone', 'string', ['limit' => 20, 'null' => false,])
                ->addColumn('created', 'datetime')
                ->addColumn('create_uid', 'integer')
                ->addColumn('modified', 'datetime')
                ->addColumn('write_uid', 'integer')
                ->addColumn('uuid', 'uuid')
        ->create();
    }
}
