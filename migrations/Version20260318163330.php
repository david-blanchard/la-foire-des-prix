<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Add discriminator columns for Single Table Inheritance on products and product_images tables.
 */
final class Version20260318163330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add dtype discriminator column to products and product_images tables for STI inheritance';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE products ADD dtype VARCHAR(50) NOT NULL DEFAULT 'product'");
        $this->addSql("ALTER TABLE product_images ADD dtype VARCHAR(50) NOT NULL DEFAULT 'product_image'");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE products DROP dtype');
        $this->addSql('ALTER TABLE product_images DROP dtype');
    }
}
