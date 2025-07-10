<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250709200852 extends AbstractMigration
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
              bill_type VARCHAR(255) NOT NULL,
              UNIQUE INDEX UNIQ_182EE6CF989D9B62 (slug),
              INDEX IDX_182EE6CF1A8C12F5 (bill_id),
              INDEX IDX_182EE6CF4584665A (product_id),
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
              campaign_type VARCHAR(255) NOT NULL,
              INDEX IDX_81CA8C25F639F774 (campaign_id),
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE campaign_product_product (
              campaign_product_id BIGINT UNSIGNED NOT NULL,
              product_id BIGINT UNSIGNED NOT NULL,
              INDEX IDX_7F249008829346F2 (campaign_product_id),
              INDEX IDX_7F2490084584665A (product_id),
              PRIMARY KEY(campaign_product_id, product_id)
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
            CREATE TABLE cloth_campaign_product (
              id BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cloth_product (
              id BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cloth_product_bill_line (
              id BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE cloth_product_image (
              id BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE food_campaign_product (
              id BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE food_product (
              id BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE food_product_bill_line (
              id BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE food_product_image (
              id BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE home_campaign_product (
              id BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE home_product (
              id BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE home_product_bill_line (
              id BIGINT UNSIGNED NOT NULL,
              PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE home_product_image (
              id BIGINT UNSIGNED NOT NULL,
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
              image_id BIGINT UNSIGNED NOT NULL,
              product_id BIGINT UNSIGNED NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              image_type VARCHAR(255) NOT NULL,
              INDEX IDX_8263FFCE3DA5256D (image_id),
              INDEX IDX_8263FFCE4584665A (product_id),
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
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              product_type VARCHAR(255) NOT NULL,
              UNIQUE INDEX UNIQ_B3BA5A5A989D9B62 (slug),
              INDEX IDX_B3BA5A5A44F5D008 (brand_id),
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
              bill_line_product
            ADD
              CONSTRAINT FK_182EE6CF4584665A FOREIGN KEY (product_id) REFERENCES products (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              campaign_products
            ADD
              CONSTRAINT FK_81CA8C25F639F774 FOREIGN KEY (campaign_id) REFERENCES campaigns (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              campaign_product_product
            ADD
              CONSTRAINT FK_7F249008829346F2 FOREIGN KEY (campaign_product_id) REFERENCES campaign_products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              campaign_product_product
            ADD
              CONSTRAINT FK_7F2490084584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              cloth_campaign_product
            ADD
              CONSTRAINT FK_AEDB9E7CBF396750 FOREIGN KEY (id) REFERENCES campaign_products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              cloth_product
            ADD
              CONSTRAINT FK_88008F82BF396750 FOREIGN KEY (id) REFERENCES products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              cloth_product_bill_line
            ADD
              CONSTRAINT FK_8F72CF76BF396750 FOREIGN KEY (id) REFERENCES bill_line_product (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              cloth_product_image
            ADD
              CONSTRAINT FK_C0ED306BBF396750 FOREIGN KEY (id) REFERENCES product_images (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              food_campaign_product
            ADD
              CONSTRAINT FK_58252774BF396750 FOREIGN KEY (id) REFERENCES campaign_products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              food_product
            ADD
              CONSTRAINT FK_9CD5D895BF396750 FOREIGN KEY (id) REFERENCES products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              food_product_bill_line
            ADD
              CONSTRAINT FK_815FB9FDBF396750 FOREIGN KEY (id) REFERENCES bill_line_product (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              food_product_image
            ADD
              CONSTRAINT FK_5EA85394BF396750 FOREIGN KEY (id) REFERENCES product_images (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              home_campaign_product
            ADD
              CONSTRAINT FK_100C9BD4BF396750 FOREIGN KEY (id) REFERENCES campaign_products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              home_product
            ADD
              CONSTRAINT FK_666ACFF5BF396750 FOREIGN KEY (id) REFERENCES products (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              home_product_bill_line
            ADD
              CONSTRAINT FK_57C133A9BF396750 FOREIGN KEY (id) REFERENCES bill_line_product (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              home_product_image
            ADD
              CONSTRAINT FK_79DEBF96BF396750 FOREIGN KEY (id) REFERENCES product_images (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              product_images
            ADD
              CONSTRAINT FK_8263FFCE3DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              product_images
            ADD
              CONSTRAINT FK_8263FFCE4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
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
            ALTER TABLE bill DROP FOREIGN KEY FK_7A2119E3A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bill_line_product DROP FOREIGN KEY FK_182EE6CF1A8C12F5
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE bill_line_product DROP FOREIGN KEY FK_182EE6CF4584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_products DROP FOREIGN KEY FK_81CA8C25F639F774
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_product_product DROP FOREIGN KEY FK_7F249008829346F2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE campaign_product_product DROP FOREIGN KEY FK_7F2490084584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cloth_campaign_product DROP FOREIGN KEY FK_AEDB9E7CBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cloth_product DROP FOREIGN KEY FK_88008F82BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cloth_product_bill_line DROP FOREIGN KEY FK_8F72CF76BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE cloth_product_image DROP FOREIGN KEY FK_C0ED306BBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_campaign_product DROP FOREIGN KEY FK_58252774BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_product DROP FOREIGN KEY FK_9CD5D895BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_product_bill_line DROP FOREIGN KEY FK_815FB9FDBF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_product_image DROP FOREIGN KEY FK_5EA85394BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE home_campaign_product DROP FOREIGN KEY FK_100C9BD4BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE home_product DROP FOREIGN KEY FK_666ACFF5BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE home_product_bill_line DROP FOREIGN KEY FK_57C133A9BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE home_product_image DROP FOREIGN KEY FK_79DEBF96BF396750
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_images DROP FOREIGN KEY FK_8263FFCE3DA5256D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_images DROP FOREIGN KEY FK_8263FFCE4584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A44F5D008
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
            DROP TABLE campaign_product_product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE campaigns
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cloth_campaign_product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cloth_product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cloth_product_bill_line
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE cloth_product_image
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE food_campaign_product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE food_product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE food_product_bill_line
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE food_product_image
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE home_campaign_product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE home_product
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE home_product_bill_line
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE home_product_image
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
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
