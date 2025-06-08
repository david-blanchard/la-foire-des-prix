<?php

namespace App\Entity\Campaign;

use App\Entity\CampaignProduct;
use App\Entity\Product\HomeProduct;
use App\Entity\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class HomeProductCampaign extends CampaignProduct
{
    private string $relation = HomeProduct::class;

    public function getRelation(): string
    {
        return $this->relation;
    }

    public function setRelation(string $relation): static
    {
        $this->relation = $relation;

        return $this;
    }
}
