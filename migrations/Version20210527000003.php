<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210527000003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création de la table products';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('products');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('description', 'string', ['length' => 1024]);
        $table->addColumn('more_infos', 'string', ['length' => 1024, 'notnull' => false]);
        $table->addColumn('price', 'float');
        $table->addColumn('brand', 'integer');
        $table->addColumn('slug', 'string', ['length' => 255, 'notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'onupdate' => 'CURRENT_TIMESTAMP']);
        $table->setPrimaryKey(['id']);
        $table->addForeignKeyConstraint('brands', ['brand'], ['id'], ['onDelete' => 'CASCADE']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('products');
    }
}
