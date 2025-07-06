<?php

namespace App\Entity\Campaign;

use App\Entity\CampaignProduct;
use App\Entity\Product\FoodProduct;
use App\Entity\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class FoodProductCampaign extends CampaignProduct
{
    public readonly string $relation;

    public function __construct()
    {
        parent::__construct();
        $this->relation = FoodProduct::class;
    }
}
