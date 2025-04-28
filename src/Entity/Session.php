<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    // Ajoutez ici les colonnes nécessaires en fonction des attributs de votre modèle Laravel

    public function getId(): ?int
    {
        return $this->id;
    }

    // Ajoutez ici les getters et setters pour chaque propriété
}
