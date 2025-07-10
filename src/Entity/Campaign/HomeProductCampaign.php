<?php

namespace App\Entity\Campaign;

use App\Entity\CampaignProduct;
use App\Entity\Product\HomeProduct;
use App\Entity\ProductInterface;
use Doctrine\ORM\Mapping as ORM;

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
