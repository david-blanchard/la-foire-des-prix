<?php

     declare(strict_types=1);

     namespace DoctrineMigrations;

     use Doctrine\DBAL\Schema\Schema;
     use Doctrine\Migrations\AbstractMigration;

     final class Version20210527000001 extends AbstractMigration
     {
         public function getDescription(): string
         {
             return 'Création de la table brands';
         }

         public function up(Schema $schema): void
         {
             $table = $schema->createTable('brands');
             $table->addColumn('id', 'integer', ['autoincrement' => true]);
             $table->addColumn('name', 'string', ['length' => 255]);
             $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
             $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'onupdate' => 'CURRENT_TIMESTAMP']);
             $table->setPrimaryKey(['id']);
         }

         public function down(Schema $schema): void
         {
             $schema->dropTable('brands');
         }
     }
