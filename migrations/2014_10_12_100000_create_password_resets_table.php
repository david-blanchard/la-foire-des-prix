<?php

     declare(strict_types=1);

     namespace DoctrineMigrations;

     use Doctrine\DBAL\Schema\Schema;
     use Doctrine\Migrations\AbstractMigration;

     final class Version20231012CreatePasswordResetsTable extends AbstractMigration
     {
         public function getDescription(): string
         {
             return 'Création de la table password_resets';
         }

         public function up(Schema $schema): void
         {
             $table = $schema->createTable('password_resets');
             $table->addColumn('email', 'string', ['length' => 255]);
             $table->addColumn('token', 'string', ['length' => 255]);
             $table->addColumn('created_at', 'datetime', ['notnull' => false]);
             $table->setPrimaryKey(['email']);
             $table->addIndex(['email']);
         }

         public function down(Schema $schema): void
         {
             $schema->dropTable('password_resets');
         }
     }
