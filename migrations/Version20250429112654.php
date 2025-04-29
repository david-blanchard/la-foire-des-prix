<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250429112654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création des tables brand, campaign, campaign_product, image, product, product_image, session et user';
    }

    public function up(Schema $schema): void
    {
        $brand = $schema->createTable('brand');
        $brand->addColumn('id', 'integer', ['autoincrement' => true]);
        $brand->addColumn('name', 'string', ['length' => 255]);
        $brand->setPrimaryKey(['id']);

        $campaign = $schema->createTable('campaign');
        $campaign->addColumn('id', 'integer', ['autoincrement' => true]);
        $campaign->addColumn('name', 'string', ['length' => 255]);
        $campaign->addColumn('start', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $campaign->addColumn('end', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $campaign->addColumn('discount', 'float', ['default' => 0]);
        $campaign->setPrimaryKey(['id']);

        $campaignProduct = $schema->createTable('campaign_product');
        $campaignProduct->addColumn('id', 'integer', ['autoincrement' => true]);
        $campaignProduct->addColumn('product_id', 'integer');
        $campaignProduct->addColumn('campaign_id', 'integer');
        $campaignProduct->addForeignKeyConstraint('product', ['product_id'], ['id']);
        $campaignProduct->addForeignKeyConstraint('campaign', ['campaign_id'], ['id']);
        $campaignProduct->addIndex(['product_id']);
        $campaignProduct->addIndex(['campaign_id']);
        $campaignProduct->setPrimaryKey(['id']);

        $image = $schema->createTable('image');
        $image->addColumn('id', 'integer', ['autoincrement' => true]);
        $image->addColumn('url', 'string', ['length' => 255]);
        $image->addColumn('alt', 'string', ['length' => 255, 'notnull' => false]);
        $image->addColumn('title', 'string', ['length' => 255, 'notnull' => false]);
        $image->setPrimaryKey(['id']);

        $product = $schema->createTable('product');
        $product->addColumn('id', 'integer', ['autoincrement' => true]);
        $product->addColumn('brand_id', 'integer');
        $product->addColumn('name', 'string', ['length' => 255]);
        $product->addColumn('description', 'text');
        $product->addColumn('more_infos', 'text', ['notnull' => false]);
        $product->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2]);
        $product->addForeignKeyConstraint('brand', ['brand_id'], ['id']);
        $product->addIndex(['brand_id']);
        $product->setPrimaryKey(['id']);

        $productImage = $schema->createTable('product_image');
        $productImage->addColumn('id', 'integer', ['autoincrement' => true]);
        $productImage->addColumn('product_id', 'integer');
        $productImage->addColumn('image_id', 'integer');
        $productImage->addForeignKeyConstraint('product', ['product_id'], ['id']);
        $productImage->addForeignKeyConstraint('image', ['image_id'], ['id']);
        $productImage->addIndex(['product_id']);
        $productImage->addIndex(['image_id']);
        $productImage->setPrimaryKey(['id']);

        $session = $schema->createTable('session');
        $session->addColumn('id', 'integer', ['autoincrement' => true]);
        $session->setPrimaryKey(['id']);

        $user = $schema->createTable('user');
        $user->addColumn('id', 'integer', ['autoincrement' => true]);
        $user->addColumn('name', 'string', ['length' => 255]);
        $user->addColumn('email', 'string', ['length' => 255]);
        $user->addColumn('password', 'string', ['length' => 255]);
        $user->addColumn('role', 'string', ['length' => 50]);
        $user->addColumn('email_verified_at', 'datetime', ['notnull' => false]);
        $user->addColumn('remember_token', 'string', ['length' => 100, 'notnull' => false]);
        $user->addColumn('roles', 'json');
        $user->addColumn('is_verified', 'boolean');
        $user->addUniqueIndex(['email'], 'UNIQ_IDENTIFIER_EMAIL');
        $user->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('campaign_product');
        $schema->dropTable('product_image');
        $schema->dropTable('product');
        $schema->dropTable('image');
        $schema->dropTable('campaign');
        $schema->dropTable('brand');
        $schema->dropTable('session');
        $schema->dropTable('user');
    }
}
