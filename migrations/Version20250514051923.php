<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250514051923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE bill (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              user_id BIGINT UNSIGNED DEFAULT NULL,
              vat DOUBLE PRECISION NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              INDEX IDX_7A2119E3A76ED395 (user_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE bill_line_product (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              bill_id BIGINT UNSIGNED NOT NULL,
              product_id BIGINT UNSIGNED NOT NULL,
              quantity SMALLINT UNSIGNED NOT NULL,
              name VARCHAR(255) NOT NULL,
              slug VARCHAR(255) DEFAULT NULL,
              category VARCHAR(255) NOT NULL,
              UNIQUE INDEX UNIQ_182EE6CF989D9B62 (slug),
              INDEX IDX_182EE6CF1A8C12F5 (bill_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE brands (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
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
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              UNIQUE INDEX UNIQ_E3737470989D9B62 (slug),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cloth_products (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              brand_id BIGINT UNSIGNED NOT NULL,
              description VARCHAR(1024) NOT NULL,
              more_info VARCHAR(1024) DEFAULT NULL,
              price DOUBLE PRECISION NOT NULL,
              name VARCHAR(255) NOT NULL,
              slug VARCHAR(255) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              UNIQUE INDEX UNIQ_18302D88989D9B62 (slug),
              INDEX IDX_18302D8844F5D008 (brand_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE food_products (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              brand_id BIGINT UNSIGNED NOT NULL,
              description VARCHAR(1024) NOT NULL,
              more_info VARCHAR(1024) DEFAULT NULL,
              price DOUBLE PRECISION NOT NULL,
              name VARCHAR(255) NOT NULL,
              slug VARCHAR(255) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              UNIQUE INDEX UNIQ_9BF77D18989D9B62 (slug),
              INDEX IDX_9BF77D1844F5D008 (brand_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE home_products (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              brand_id BIGINT UNSIGNED NOT NULL,
              description VARCHAR(1024) NOT NULL,
              more_info VARCHAR(1024) DEFAULT NULL,
              price DOUBLE PRECISION NOT NULL,
              name VARCHAR(255) NOT NULL,
              slug VARCHAR(255) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              UNIQUE INDEX UNIQ_D6BFA357989D9B62 (slug),
              INDEX IDX_D6BFA35744F5D008 (brand_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE images (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              url VARCHAR(255) NOT NULL,
              alt VARCHAR(255) NOT NULL,
              title VARCHAR(255) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE product_images (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              product_id BIGINT UNSIGNED NOT NULL,
              image_id BIGINT UNSIGNED NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              INDEX IDX_8263FFCE4584665A (product_id),
              INDEX IDX_8263FFCE3DA5256D (image_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `user` (
              id BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
              email VARCHAR(180) NOT NULL,
              roles JSON NOT NULL,
              password VARCHAR(255) NOT NULL,
              is_verified TINYINT(1) NOT NULL,
              UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (
              id BIGINT AUTO_INCREMENT NOT NULL,
              body LONGTEXT NOT NULL,
              headers LONGTEXT NOT NULL,
              queue_name VARCHAR(190) NOT NULL,
              created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
              available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)',
              delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
              INDEX IDX_75EA56E0FB7336F0 (queue_name),
              INDEX IDX_75EA56E0E3BD61CE (available_at),
              INDEX IDX_75EA56E016BA31DB (delivered_at),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              bill
            ADD
              CONSTRAINT FK_7A2119E3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              bill_line_product
            ADD
              CONSTRAINT FK_182EE6CF1A8C12F5 FOREIGN KEY (bill_id) REFERENCES bill (id)
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
              CONSTRAINT FK_81CA8C254584665A FOREIGN KEY (product_id) REFERENCES cloth_products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              cloth_products
            ADD
              CONSTRAINT FK_18302D8844F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              food_products
            ADD
              CONSTRAINT FK_9BF77D1844F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              home_products
            ADD
              CONSTRAINT FK_D6BFA35744F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              product_images
            ADD
              CONSTRAINT FK_8263FFCE4584665A FOREIGN KEY (product_id) REFERENCES cloth_products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              product_images
            ADD
              CONSTRAINT FK_8263FFCE3DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E3A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bill_line_product DROP FOREIGN KEY FK_182EE6CF1A8C12F5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_products DROP FOREIGN KEY FK_81CA8C25F639F774
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_products DROP FOREIGN KEY FK_81CA8C254584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cloth_products DROP FOREIGN KEY FK_18302D8844F5D008
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_products DROP FOREIGN KEY FK_9BF77D1844F5D008
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE home_products DROP FOREIGN KEY FK_D6BFA35744F5D008
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_images DROP FOREIGN KEY FK_8263FFCE4584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_images DROP FOREIGN KEY FK_8263FFCE3DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bill
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE bill_line_product
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
            DROP TABLE cloth_products
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE food_products
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE home_products
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE images
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product_images
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `user`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
