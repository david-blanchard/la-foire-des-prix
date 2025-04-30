<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250430122448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE brand (
              id INT AUTO_INCREMENT NOT NULL,
              name VARCHAR(255) NOT NULL,
              slug VARCHAR(255) DEFAULT NULL,
              UNIQUE INDEX UNIQ_1C52F958989D9B62 (slug),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE campaign (
              id INT AUTO_INCREMENT NOT NULL,
              starts_at DATE NOT NULL COMMENT '(DC2Type:date_immutable)',
              ends_at DATE NOT NULL COMMENT '(DC2Type:date_immutable)',
              discount DOUBLE PRECISION NOT NULL,
              name VARCHAR(255) NOT NULL,
              slug VARCHAR(255) DEFAULT NULL,
              UNIQUE INDEX UNIQ_1F1512DD989D9B62 (slug),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE campaign_product (
              id INT AUTO_INCREMENT NOT NULL,
              product_id INT DEFAULT NULL,
              campaign_id INT DEFAULT NULL,
              INDEX IDX_7BF098814584665A (product_id),
              INDEX IDX_7BF09881F639F774 (campaign_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE image (
              id INT AUTO_INCREMENT NOT NULL,
              url VARCHAR(255) NOT NULL,
              alt VARCHAR(255) NOT NULL,
              title VARCHAR(255) NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product (
              id INT AUTO_INCREMENT NOT NULL,
              brand_id INT DEFAULT NULL,
              image_id INT DEFAULT NULL,
              description LONGTEXT DEFAULT NULL,
              more_info LONGTEXT DEFAULT NULL,
              price DOUBLE PRECISION NOT NULL,
              name VARCHAR(255) NOT NULL,
              slug VARCHAR(255) DEFAULT NULL,
              UNIQUE INDEX UNIQ_D34A04AD989D9B62 (slug),
              INDEX IDX_D34A04AD44F5D008 (brand_id),
              INDEX IDX_D34A04AD3DA5256D (image_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product_image (
              id INT AUTO_INCREMENT NOT NULL,
              product_id INT DEFAULT NULL,
              image_id INT DEFAULT NULL,
              INDEX IDX_64617F034584665A (product_id),
              INDEX IDX_64617F033DA5256D (image_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE session (
              id INT AUTO_INCREMENT NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (
              id INT AUTO_INCREMENT NOT NULL,
              name VARCHAR(255) NOT NULL,
              email VARCHAR(180) NOT NULL,
              password VARCHAR(255) NOT NULL,
              role VARCHAR(50) NOT NULL,
              email_verified_at DATETIME DEFAULT NULL,
              remember_token VARCHAR(100) DEFAULT NULL,
              roles JSON NOT NULL,
              is_verified TINYINT(1) NOT NULL,
              UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              campaign_product
            ADD
              CONSTRAINT FK_7BF098814584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              campaign_product
            ADD
              CONSTRAINT FK_7BF09881F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              product
            ADD
              CONSTRAINT FK_D34A04AD44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              product
            ADD
              CONSTRAINT FK_D34A04AD3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              product_image
            ADD
              CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              product_image
            ADD
              CONSTRAINT FK_64617F033DA5256D FOREIGN KEY (image_id) REFERENCES image (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_product DROP FOREIGN KEY FK_7BF098814584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_product DROP FOREIGN KEY FK_7BF09881F639F774
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD44F5D008
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD3DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_image DROP FOREIGN KEY FK_64617F033DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE brand
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE campaign
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE campaign_product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE image
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product_image
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE session
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
    }
}
