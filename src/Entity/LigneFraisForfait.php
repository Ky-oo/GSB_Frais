<?php

namespace App\Entity;

use App\Repository\LigneFraisForfaitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneFraisForfaitRepository::class)]
class LigneFraisForfait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'ligneFraisForfaits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FraisForfait $FraisForfait = null;

    #[ORM\ManyToOne(inversedBy: 'ligneFraisForfait')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FicheFrais $ficheFrais = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getFraisForfait(): ?FraisForfait
    {
        return $this->FraisForfait;
    }

    public function setFraisForfait(?FraisForfait $FraisForfait): static
    {
        $this->FraisForfait = $FraisForfait;

        return $this;
    }

    public function getFicheFrais(): ?FicheFrais
    {
        return $this->ficheFrais;
    }

    public function setFicheFrais(?FicheFrais $ficheFrais): static
    {
        $this->ficheFrais = $ficheFrais;

        return $this;
    }
}
