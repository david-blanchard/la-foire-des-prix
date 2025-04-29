<?php

            declare(strict_types=1);

            namespace DoctrineMigrations;

            use Doctrine\DBAL\Schema\Schema;
            use Doctrine\Migrations\AbstractMigration;

            final class Version20210527000002 extends AbstractMigration
            {
                public function getDescription(): string
                {
                    return 'Création de la table images';
                }

                public function up(Schema $schema): void
                {
                    $table = $schema->createTable('images');
                    $table->addColumn('id', 'integer', ['autoincrement' => true]);
                    $table->addColumn('url', 'string', ['length' => 255]);
                    $table->addColumn('alt', 'string', ['length' => 255]);
                    $table->addColumn('title', 'string', ['length' => 255]);
                    $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
                    $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'onupdate' => 'CURRENT_TIMESTAMP']);
                    $table->setPrimaryKey(['id']);
                }

                public function down(Schema $schema): void
                {
                    $schema->dropTable('images');
                }
            }
