<?php

namespace App\Entity;

interface ProductInterface extends CategoryInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function getDescription(): ?string;

    public function getMoreInfo(): ?string;

    public function getPrice(): float;

    public function getBrand(): ?Brand;
}
