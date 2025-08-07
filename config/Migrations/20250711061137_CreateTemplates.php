<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateTemplates extends BaseMigration
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
        $table = $this->table('templates');
        $table->addColumn('name', 'string', ['limit' => 100])
              ->addColumn('content', 'text')
              ->addColumn('created', 'datetime')
              ->addColumn('create_uid', 'integer')
              ->addColumn('modified', 'datetime')
              ->addColumn('write_uid', 'integer')
              ->addColumn('uuid', 'uuid')
        ->create();
    }
}
