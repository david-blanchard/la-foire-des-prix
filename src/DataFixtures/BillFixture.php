<?php

namespace App\DataFixtures;

use App\Entity\Bill;
use App\Entity\BillLineProduct;
use App\Entity\Product;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BillFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // TODO: Implement execute() method.
        $userRepo = $manager->getRepository(User::class);
        $user = $userRepo->findOneBy(['email' => 'dblanchard1@lfdp.fr']);

        $productRepo = $manager->getRepository(Product::class);
        $product1 = $productRepo->findOneBy(['name' => ProductsFixture::PRODUCT_LABEL_1]);
        $product2 = $productRepo->findOneBy(['name' => ProductsFixture::PRODUCT_LABEL_2]);
        $product3 = $productRepo->findOneBy(['name' => ProductsFixture::PRODUCT_LABEL_3]);

        $bill = new Bill();
        $bill->setClient($user);
        $bill->setCreatedAt(new DateTime());
        $bill->setVat(19.6);
        $manager->persist($bill);

        $billLine1 = new BillLineProduct();
        $billLine1->setBill($bill);
        $billLine1->setName((string)$product1?->getName());
        $billLine1->setProduct($product1);
        $billLine1->setQuantity(1);
        $manager->persist($billLine1);

        $billLine2 = new BillLineProduct();
        $billLine2->setBill($bill);
        $billLine2->setName((string)$product2?->getName());
        $billLine2->setProduct($product2);
        $billLine2->setQuantity(2);
        $manager->persist($billLine2);

        $billLine3 = new BillLineProduct();
        $billLine3->setBill($bill);
        $billLine3->setName((string)$product3?->getName());
        $billLine3->setProduct($product3);
        $billLine3->setQuantity(1);
        $manager->persist($billLine3);

        $bill->addBillLine($billLine1);
        $bill->addBillLine($billLine2);
        $bill->addBillLine($billLine3);
        $bill->setUpdatedAt(new DateTime());
        $manager->persist($bill);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            ProductsFixture::class,
        ];
    }
}
