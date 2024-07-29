<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateMetadata extends AbstractMigration
{
    /**
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('metadata');

        $table
            ->addColumn('entity', 'string', ['null' => false, 'limit' => 25])
            ->addColumn('meta', 'string', ['null' => false, 'limit' => 25])
            ->addColumn('value', 'string', ['null' => false, 'limit' => 100])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'precision' => 0])
            ->addColumn('modified', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'precision' => 0])
            ->addColumn('is_public', 'boolean', ['null' => false, 'default' => true]);

        $table
            ->addIndex('entity')
            ->addIndex('meta')
            ->addIndex('is_public');

        $table->create();
    }
}
