<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateGenders extends BaseMigration
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
        $table = $this->table('genders');
        $table->addColumn('name', 'string', ['limit' => 200])
                ->addColumn('note', 'text', ['null' => true])
                ->addColumn('created', 'datetime')
                ->addColumn('create_uid', 'integer')
                ->addColumn('modified', 'datetime')
                ->addColumn('write_uid', 'integer')
                ->addColumn('uuid', 'char', ['limit' => 36])
        ->create();
    }
}
