<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateRoles extends AbstractMigration
{
    /**
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('roles');

        $table
            ->addColumn('name', 'string', ['null' => false, 'limit' => 25])
            ->addColumn('capabilities', 'text', ['null' => false])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'precision' => 0])
            ->addColumn('modified', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'precision' => 0])
            ->addColumn('is_public', 'boolean', ['null' => false, 'default' => true]);

        $table->create();
    }
}
