<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateReminders extends BaseMigration
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
        $table = $this->table('reminders');
        $table ->addColumn('gender_id', 'integer')
                ->addColumn('template_id', 'integer')
                ->addColumn('date_before1', 'integer', ['default' => 0])
                ->addColumn('date_before2', 'integer', ['default' => 0])
                ->addColumn('date_before3', 'integer', ['default' => 0])
                ->addColumn('date_before4', 'integer', ['default' => 0])
                ->addColumn('days_after', 'integer', ['default' => 0])
                ->addColumn('created', 'datetime')
                ->addColumn('create_uid', 'integer')
                ->addColumn('modified', 'datetime')
                ->addColumn('write_uid', 'integer')
                ->addColumn('uuid', 'char', ['limit' => 36])
                ->addIndex(['gender_id'])
                ->addIndex(['template_id'])
        ->create();
    }
}
