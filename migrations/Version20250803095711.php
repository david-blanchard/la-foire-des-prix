<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250803095711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE bill_lines_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE bills_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE brands_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE campaign_products_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE campaigns_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE images_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_images_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE products_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE bill_lines (
          id BIGINT NOT NULL,
          bill_id BIGINT DEFAULT NULL,
          product_id BIGINT DEFAULT NULL,
          name VARCHAR(255) NOT NULL,
          quantity SMALLINT NOT NULL,
          slug VARCHAR(255) DEFAULT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_79F1D908989D9B62 ON bill_lines (slug)');
        $this->addSql('CREATE INDEX IDX_79F1D9081A8C12F5 ON bill_lines (bill_id)');
        $this->addSql('CREATE INDEX IDX_79F1D9084584665A ON bill_lines (product_id)');
        $this->addSql('CREATE TABLE bills (
          id BIGINT NOT NULL,
          client_id BIGINT DEFAULT NULL,
          vat DOUBLE PRECISION NOT NULL,
          created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_22775DD019EB6921 ON bills (client_id)');
        $this->addSql('CREATE TABLE brands (
          id BIGINT NOT NULL,
          name VARCHAR(255) NOT NULL,
          created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          slug VARCHAR(255) DEFAULT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7EA24434989D9B62 ON brands (slug)');
        $this->addSql('CREATE TABLE campaign_products (
          id BIGINT NOT NULL,
          campaign_id BIGINT NOT NULL,
          product_id BIGINT NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_81CA8C25F639F774 ON campaign_products (campaign_id)');
        $this->addSql('CREATE INDEX IDX_81CA8C254584665A ON campaign_products (product_id)');
        $this->addSql('CREATE TABLE campaigns (
          id BIGINT NOT NULL,
          name VARCHAR(255) NOT NULL,
          starts_at DATE NOT NULL,
          ends_at DATE NOT NULL,
          discount SMALLINT NOT NULL,
          slug VARCHAR(255) DEFAULT NULL,
          created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E3737470989D9B62 ON campaigns (slug)');
        $this->addSql('COMMENT ON COLUMN campaigns.starts_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN campaigns.ends_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE images (
          id BIGINT NOT NULL,
          url VARCHAR(255) NOT NULL,
          alt VARCHAR(255) NOT NULL,
          title VARCHAR(255) DEFAULT NULL,
          created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE TABLE product_images (
          id BIGINT NOT NULL,
          image_id BIGINT NOT NULL,
          product_id BIGINT NOT NULL,
          created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_8263FFCE3DA5256D ON product_images (image_id)');
        $this->addSql('CREATE INDEX IDX_8263FFCE4584665A ON product_images (product_id)');
        $this->addSql('CREATE TABLE products (
          id BIGINT NOT NULL,
          brand_id BIGINT NOT NULL,
          name VARCHAR(255) DEFAULT NULL,
          description VARCHAR(1024) DEFAULT NULL,
          more_info VARCHAR(1024) DEFAULT NULL,
          price DOUBLE PRECISION NOT NULL,
          slug VARCHAR(255) DEFAULT NULL,
          created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B3BA5A5A989D9B62 ON products (slug)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A44F5D008 ON products (brand_id)');
        $this->addSql('CREATE TABLE "user" (
          id BIGINT NOT NULL,
          email VARCHAR(180) NOT NULL,
          roles JSON NOT NULL,
          password VARCHAR(255) NOT NULL,
          is_verified BOOLEAN NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE messenger_messages (
          id BIGSERIAL NOT NULL,
          body TEXT NOT NULL,
          headers TEXT NOT NULL,
          queue_name VARCHAR(190) NOT NULL,
          created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE
        OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$ BEGIN
          PERFORM pg_notify(
            \'messenger_messages\', NEW.queue_name :: text
          );

          RETURN NEW;
        END;

        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT
        OR
        UPDATE
          ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE
          bill_lines
        ADD
          CONSTRAINT FK_79F1D9081A8C12F5 FOREIGN KEY (bill_id) REFERENCES bills (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          bill_lines
        ADD
          CONSTRAINT FK_79F1D9084584665A FOREIGN KEY (product_id) REFERENCES products (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          bills
        ADD
          CONSTRAINT FK_22775DD019EB6921 FOREIGN KEY (client_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          campaign_products
        ADD
          CONSTRAINT FK_81CA8C25F639F774 FOREIGN KEY (campaign_id) REFERENCES campaigns (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          campaign_products
        ADD
          CONSTRAINT FK_81CA8C254584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          product_images
        ADD
          CONSTRAINT FK_8263FFCE3DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          product_images
        ADD
          CONSTRAINT FK_8263FFCE4584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          products
        ADD
          CONSTRAINT FK_B3BA5A5A44F5D008 FOREIGN KEY (brand_id) REFERENCES brands (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE bill_lines_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE bills_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE brands_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE campaign_products_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE campaigns_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE images_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_images_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE products_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE bill_lines DROP CONSTRAINT FK_79F1D9081A8C12F5');
        $this->addSql('ALTER TABLE bill_lines DROP CONSTRAINT FK_79F1D9084584665A');
        $this->addSql('ALTER TABLE bills DROP CONSTRAINT FK_22775DD019EB6921');
        $this->addSql('ALTER TABLE campaign_products DROP CONSTRAINT FK_81CA8C25F639F774');
        $this->addSql('ALTER TABLE campaign_products DROP CONSTRAINT FK_81CA8C254584665A');
        $this->addSql('ALTER TABLE product_images DROP CONSTRAINT FK_8263FFCE3DA5256D');
        $this->addSql('ALTER TABLE product_images DROP CONSTRAINT FK_8263FFCE4584665A');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A44F5D008');
        $this->addSql('DROP TABLE bill_lines');
        $this->addSql('DROP TABLE bills');
        $this->addSql('DROP TABLE brands');
        $this->addSql('DROP TABLE campaign_products');
        $this->addSql('DROP TABLE campaigns');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE product_images');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
