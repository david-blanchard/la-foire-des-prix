<?php

namespace App\Entity\Base;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;

trait ClassifierTrait
{

    #[ORM\Column(length: 255)]
    protected ?string $name = null;

    #[Slug(fields: ['name'])]
    #[ORM\Column(length: 255, unique: true, nullable: true)]
    protected ?string $slug = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

}
