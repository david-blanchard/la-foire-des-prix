<?php

namespace App\Entity;

use App\Entity\BillLine\ProductBillLineInterface;
use Doctrine\Common\Collections\Collection;

interface ProductInterface extends ProductBillLineInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function getDescription(): string;

    public function getMoreInfo(): ?string;

    public function getPrice(): float;

    public function getBrand(): ?Brand;

    /**
     * @return Collection<int, CampaignProduct>
     */
    public function getCampaignProducts(): Collection;

    /**
     * @return Collection<int, ProductImage>
     */
    public function getProductImages(): Collection;

    public function addImage(Image $image): self;
}
