<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    final class Version20210527000006 extends AbstractMigration
    {
        public function getDescription(): string
        {
            return 'Création de la table campaign_products';
        }

        public function up(Schema $schema): void
        {
            $table = $schema->createTable('campaign_products');
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('campaign', 'integer');
            $table->addColumn('product', 'integer');
            $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
            $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'onupdate' => 'CURRENT_TIMESTAMP']);
            $table->setPrimaryKey(['id']);
            $table->addForeignKeyConstraint('campaigns', ['campaign'], ['id'], ['onDelete' => 'CASCADE']);
            $table->addForeignKeyConstraint('products', ['product'], ['id'], ['onDelete' => 'CASCADE']);
        }

        public function down(Schema $schema): void
        {
            $schema->dropTable('campaign_products');
        }
    }
