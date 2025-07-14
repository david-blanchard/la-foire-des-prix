<?php

namespace App\Entity\Campaign;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\CampaignProduct;
use App\Entity\Product\HomeProduct;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(mercure: true)]
#[ORM\Entity()]
#[ORM\Table(name: 'home_campaign_product')]
class HomeProductCampaign extends CampaignProduct
{
    public readonly string $campaign_type;

    public function __construct()
    {
        parent::__construct();
        $this->campaign_type = HomeProduct::class;
    }
}
