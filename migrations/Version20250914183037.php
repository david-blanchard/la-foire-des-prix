<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250914183037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE city_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE address (id BIGINT NOT NULL, city_id BIGINT NOT NULL, line1 VARCHAR(255) NOT NULL, line2 VARCHAR(255) DEFAULT NULL, details TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D4E6F818BAC62AF ON address (city_id)');
        $this->addSql('CREATE TABLE city (id BIGINT NOT NULL, country_code VARCHAR(3) NOT NULL, name VARCHAR(255) NOT NULL, zipcode VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2D5B0234F026BB7C ON city (country_code)');
        $this->addSql('CREATE TABLE country (code VARCHAR(3) NOT NULL, name VARCHAR(128) NOT NULL, PRIMARY KEY(code))');
        $this->addSql('CREATE TABLE user_address (user_id BIGINT NOT NULL, address_id BIGINT NOT NULL, PRIMARY KEY(user_id, address_id))');
        $this->addSql('CREATE INDEX IDX_5543718BA76ED395 ON user_address (user_id)');
        $this->addSql('CREATE INDEX IDX_5543718BF5B7AF75 ON user_address (address_id)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F818BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F026BB7C FOREIGN KEY (country_code) REFERENCES country (code) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_address ADD CONSTRAINT FK_5543718BF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD gender VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE city_id_seq CASCADE');
        $this->addSql('ALTER TABLE address DROP CONSTRAINT FK_D4E6F818BAC62AF');
        $this->addSql('ALTER TABLE city DROP CONSTRAINT FK_2D5B0234F026BB7C');
        $this->addSql('ALTER TABLE user_address DROP CONSTRAINT FK_5543718BA76ED395');
        $this->addSql('ALTER TABLE user_address DROP CONSTRAINT FK_5543718BF5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE user_address');
        $this->addSql('ALTER TABLE "user" DROP gender');
        $this->addSql('ALTER TABLE "user" DROP first_name');
        $this->addSql('ALTER TABLE "user" DROP last_name');
    }
}
