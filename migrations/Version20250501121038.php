<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250501121038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE brands (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              created_at DATETIME DEFAULT NULL,
              updated_at DATETIME DEFAULT NULL,
              name VARCHAR(255) NOT NULL,
              slug VARCHAR(255) DEFAULT NULL,
              UNIQUE INDEX UNIQ_7EA24434989D9B62 (slug),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE campaign_products (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              campaign_id BIGINT UNSIGNED NOT NULL,
              product_id BIGINT UNSIGNED NOT NULL,
              INDEX IDX_81CA8C25F639F774 (campaign_id),
              INDEX IDX_81CA8C254584665A (product_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE campaigns (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              starts_at DATE NOT NULL COMMENT '(DC2Type:date_immutable)',
              ends_at DATE NOT NULL COMMENT '(DC2Type:date_immutable)',
              discount SMALLINT NOT NULL,
              name VARCHAR(255) NOT NULL,
              slug VARCHAR(255) DEFAULT NULL,
              created_at DATETIME DEFAULT NULL,
              updated_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_E3737470989D9B62 (slug),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE images (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              url VARCHAR(255) NOT NULL,
              alt VARCHAR(255) NOT NULL,
              title VARCHAR(255) NOT NULL,
              created_at DATETIME DEFAULT NULL,
              updated_at DATETIME DEFAULT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product_images (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              product_id BIGINT UNSIGNED NOT NULL,
              image_id BIGINT UNSIGNED NOT NULL,
              created_at DATETIME DEFAULT NULL,
              updated_at DATETIME DEFAULT NULL,
              INDEX IDX_8263FFCE4584665A (product_id),
              INDEX IDX_8263FFCE3DA5256D (image_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE products (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              brand_id BIGINT UNSIGNED NOT NULL,
              description VARCHAR(1024) NOT NULL,
              more_info VARCHAR(1024) DEFAULT NULL,
              price DOUBLE PRECISION NOT NULL,
              name VARCHAR(255) NOT NULL,
              slug VARCHAR(255) DEFAULT NULL,
              created_at DATETIME DEFAULT NULL,
              updated_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_B3BA5A5A989D9B62 (slug),
              INDEX IDX_B3BA5A5A44F5D008 (brand_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
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
              campaign_products
            ADD
              CONSTRAINT FK_81CA8C25F639F774 FOREIGN KEY (campaign_id) REFERENCES campaigns (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              campaign_products
            ADD
              CONSTRAINT FK_81CA8C254584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              product_images
            ADD
              CONSTRAINT FK_8263FFCE4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              product_images
            ADD
              CONSTRAINT FK_8263FFCE3DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              products
            ADD
              CONSTRAINT FK_B3BA5A5A44F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_products DROP FOREIGN KEY FK_81CA8C25F639F774
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_products DROP FOREIGN KEY FK_81CA8C254584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_images DROP FOREIGN KEY FK_8263FFCE4584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_images DROP FOREIGN KEY FK_8263FFCE3DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A44F5D008
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE brands
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE campaign_products
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE campaigns
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE images
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product_images
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE products
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
    }
}
