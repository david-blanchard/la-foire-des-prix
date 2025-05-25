<?php

namespace App\Entity\Traits;

use App\Doctrine\UuidGenerator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

trait Identifier
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected ?Uuid $id = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }
}
