<?php

namespace App\Entity;

use App\Entity\Category\ClothProductCategory;
use App\Entity\Category\FoodProductCategory;
use App\Entity\Category\HomeProductCategory;
use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'cloths' => ClothProductCategory::class,
    'food' => FoodProductCategory::class,
    'home' => HomeProductCategory::class,
])]
class BillLine
{
    use Identifier;
    use Classifier;

    private string $relationId

    public function __construct()
    {
    }

    public function getRelationId(): string
    {
        return $this->relationId;
    }
    public function setRelationId(string $relationId): self
    {
        $this->relationId = $relationId;
        return $this;
    }

}
