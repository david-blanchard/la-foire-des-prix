<?php

namespace App\Entity\Campaign;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\CampaignProduct;
use App\Entity\Product\FoodProduct;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(mercure: true)]
#[ORM\Entity()]
#[ORM\Table(name: 'food_campaign_product')]
class FoodProductCampaign extends CampaignProduct
{
    public readonly string $campaign_type;

    public function __construct()
    {
        parent::__construct();
        $this->campaign_type = FoodProduct::class;
    }
}
