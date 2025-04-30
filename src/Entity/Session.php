<?php

namespace App\Entity;

use App\Entity\Base\IdentifierTrait;
use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    use IdentifierTrait;
}
