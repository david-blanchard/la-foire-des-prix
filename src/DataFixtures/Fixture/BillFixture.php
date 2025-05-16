<?php

namespace App\DataFixtures\Fixture;

use App\Entity\Bill;
use App\Entity\Category\ClothProductCategory;
use App\Entity\Product\ClothProduct;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class BillFixture implements CustomFixtureInterface
{
    public function execute(ObjectManager $manager): void
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

        $billLine1 = new ClothProductCategory();
        $billLine1->setBill($bill);
        $billLine1->setCategory($product1);
        $billLine1->setName($product1->getName());
        $billLine1->setProductId($product1->getId());
        $billLine1->setQuantity(1);
        $manager->persist($billLine1);

        $billLine2 = new ClothProductCategory();
        $billLine2->setBill($bill);
        $billLine2->setCategory($product2);
        $billLine2->setName($product2->getName());
        $billLine2->setProductId($product2->getId());
        $billLine2->setQuantity(2);
        $manager->persist($billLine2);

        $billLine3 = new ClothProductCategory();
        $billLine3->setBill($bill);
        $billLine3->setCategory($product3);
        $billLine3->setName($product3->getName());
        $billLine3->setProductId($product3->getId());
        $billLine3->setQuantity(1);
        $manager->persist($billLine3);

        $bill->addBillLine($billLine1);
        $bill->addBillLine($billLine2);
        $bill->addBillLine($billLine3);
        $bill->setUpdatedAt(new \DateTime());
        $manager->persist($bill);

        $manager->flush();
    }
}
