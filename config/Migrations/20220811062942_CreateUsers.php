<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('users');

        $table
            ->addColumn('username', 'string', ['null' => false, 'limit' => 50])
            ->addColumn('email', 'string', ['null' => false, 'limit' => 100])
            ->addColumn('password', 'string', ['null' => false, 'limit' => 100])
            ->addColumn('role_id', 'integer', ['null' => false])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'precision' => 0])
            ->addColumn('modified', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'precision' => 0])
            ->addColumn('is_public', 'boolean', ['null' => false, 'default' => true]);

        $table
            ->addIndex('username', ['unique' => true])
            ->addIndex('email', ['unique' => true])
            ->addIndex('is_public');

        $table
            ->addForeignKey('role_id', 'roles', 'id');

        $table->create();
    }
}
