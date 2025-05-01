<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Identifier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'bigint', options: ['unsigned' => true])]
    protected ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
