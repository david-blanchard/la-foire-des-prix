<?php

namespace App\Entity\Campaign;

use App\Entity\CampaignProduct;
use App\Entity\Product\ClothProduct;
use App\Entity\ProductInterface;
use App\Repository\ClothProductCampaignRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClothProductCampaignRepository::class)]
#[ORM\Table(name: 'cloth_campaign_product')]
class ClothProductCampaign extends CampaignProduct
{
    public readonly string $relation;

    public function __construct()
    {
        parent::__construct();
        $this->relation = ClothProduct::class;
    }

}
