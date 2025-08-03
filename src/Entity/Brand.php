<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\Classifier;
use App\Entity\Traits\Identifier;
use App\Repository\BrandRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: [
        'groups' => ['brand.read'],
    ],
    denormalizationContext: [
        'groups' => ['brand.write'],
    ],
    mercure: true
)]
#[ORM\Entity(repositoryClass: BrandRepository::class)]
#[ORM\Table(name: 'brands')]
class Brand
{
    use Identifier;
    use TimestampableEntity;
    use Classifier;

    #[ORM\Column(length: 255)]
    #[Groups(['brand.read', 'brand.write'])]
    protected ?string $name = null;
}
