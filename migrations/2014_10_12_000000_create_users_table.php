<?php

     declare(strict_types=1);

     namespace DoctrineMigrations;

     use Doctrine\DBAL\Schema\Schema;
     use Doctrine\Migrations\AbstractMigration;

     final class Version20231012CreateUsersTable extends AbstractMigration
     {
         public function getDescription(): string
         {
             return 'Création de la table users';
         }

         public function up(Schema $schema): void
         {
             $table = $schema->createTable('users');
             $table->addColumn('id', 'integer', ['autoincrement' => true]);
             $table->addColumn('name', 'string', ['length' => 255]);
             $table->addColumn('email', 'string', ['length' => 255]);
             $table->addColumn('email_verified_at', 'datetime', ['notnull' => false]);
             $table->addColumn('password', 'string', ['length' => 255]);
             $table->addColumn('role', 'string', ['length' => 255]);
             $table->addColumn('remember_token', 'string', ['length' => 100, 'notnull' => false]);
             $table->addColumn('created_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
             $table->addColumn('updated_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'onupdate' => 'CURRENT_TIMESTAMP']);
             $table->setPrimaryKey(['id']);
             $table->addUniqueIndex(['email']);
         }

         public function down(Schema $schema): void
         {
             $schema->dropTable('users');
         }
     }
