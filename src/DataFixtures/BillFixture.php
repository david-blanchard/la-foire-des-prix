<?php

namespace App\DataFixtures;

use App\Entity\Bill;
use App\Entity\BillLine\ClothProductBillLine;
use App\Entity\Product\ClothProduct;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BillFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // TODO: Implement execute() method.
        $userRepo = $manager->getRepository(User::class);
        $user = $userRepo->findOneBy(['email' => 'dblanchard1@lfdp.fr']);

        $productRepo = $manager->getRepository(ClothProduct::class);
        $product1 = $productRepo->findOneBy(['name' => ProductsFixture::PRODUCT_LABEL_1]);
        $product2 = $productRepo->findOneBy(['name' => ProductsFixture::PRODUCT_LABEL_2]);
        $product3 = $productRepo->findOneBy(['name' => ProductsFixture::PRODUCT_LABEL_3]);

        $bill = new Bill();
        $bill->setUser($user);
        $bill->setCreatedAt(new \DateTime());
        $bill->setVat(19.6);
        $manager->persist($bill);

        $billLine1 = new ClothProductBillLine();
        $billLine1->setBill($bill);
        $billLine1->setProduct($product1);
        $billLine1->setName((string) $product1?->getName());
        $billLine1->setProductId((int) $product1?->getId());
        $billLine1->setQuantity(1);
        $manager->persist($billLine1);

        $billLine2 = new ClothProductBillLine();
        $billLine2->setBill($bill);
        $billLine2->setProduct($product2);
        $billLine2->setName((string) $product2?->getName());
        $billLine2->setProductId((int) $product2?->getId());
        $billLine2->setQuantity(2);
        $manager->persist($billLine2);

        $billLine3 = new ClothProductBillLine();
        $billLine3->setBill($bill);
        $billLine3->setProduct($product3);
        $billLine3->setName((string) $product3?->getName());
        $billLine3->setProductId((int) $product3?->getId());
        $billLine3->setQuantity(1);
        $manager->persist($billLine3);

        $bill->addBillLine($billLine1);
        $bill->addBillLine($billLine2);
        $bill->addBillLine($billLine3);
        $bill->setUpdatedAt(new \DateTime());
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
