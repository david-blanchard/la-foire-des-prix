<?php

     declare(strict_types=1);

     namespace DoctrineMigrations;

     use Doctrine\DBAL\Schema\Schema;
     use Doctrine\Migrations\AbstractMigration;

     final class Version20190819000000 extends AbstractMigration
     {
         public function getDescription(): string
         {
             return 'Création de la table failed_jobs';
         }

         public function up(Schema $schema): void
         {
             $table = $schema->createTable('failed_jobs');
             $table->addColumn('id', 'integer', ['autoincrement' => true]);
             $table->addColumn('uuid', 'string', ['length' => 255]);
             $table->addColumn('connection', 'text');
             $table->addColumn('queue', 'text');
             $table->addColumn('payload', 'text');
             $table->addColumn('exception', 'text');
             $table->addColumn('failed_at', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
             $table->setPrimaryKey(['id']);
             $table->addUniqueIndex(['uuid']);
         }

         public function down(Schema $schema): void
         {
             $schema->dropTable('failed_jobs');
         }
     }
