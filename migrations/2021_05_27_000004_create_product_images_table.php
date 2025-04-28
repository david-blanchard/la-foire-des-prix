<?php

    declare(strict_types=1);

    namespace DoctrineMigrations;

    use Doctrine\DBAL\Schema\Schema;
    use Doctrine\Migrations\AbstractMigration;

    final class Version20231012CreateProductImagesTable extends AbstractMigration
    {
        public function getDescription(): string
        {
            return 'Création de la table product_images';
        }

        public function up(Schema $schema): void
        {
            $table = $schema->createTable('product_images');
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('product', 'integer');
            $table->addColumn('image', 'integer');
            $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
            $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'onupdate' => 'CURRENT_TIMESTAMP']);
            $table->setPrimaryKey(['id']);
            $table->addForeignKeyConstraint('products', ['product'], ['id'], ['onDelete' => 'CASCADE']);
            $table->addForeignKeyConstraint('images', ['image'], ['id'], ['onDelete' => 'CASCADE']);
        }

        public function down(Schema $schema): void
        {
            $schema->dropTable('product_images');
        }
    }
