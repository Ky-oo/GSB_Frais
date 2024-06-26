<?php

namespace App\Entity;

use App\Repository\FicheFraisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FicheFraisRepository::class)]
class FicheFrais
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $mois = null;

    #[ORM\Column]
    private ?int $nbJustificatifs = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $montantValid = null;

    #[ORM\ManyToOne(inversedBy: 'ficheFrais')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etat $etat = null;

    #[ORM\OneToMany(mappedBy: 'ficheFrais', targetEntity: LigneFraisHorsForfait::class)]
    private Collection $LigneFraisHorsForfait;

    #[ORM\ManyToOne(inversedBy: 'ficheFrais')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'ficheFrais', targetEntity: LigneFraisForfait::class, orphanRemoval: true)]
    private Collection $ligneFraisForfait;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateModif = null;

    public function __construct()
    {
        $this->LigneFraisHorsForfait = new ArrayCollection();
        $this->ligneFraisForfait = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): static
    {
        $this->mois = $mois;

        return $this;
    }

    public function getNbJustificatifs(): ?int
    {
        return $this->nbJustificatifs;
    }

    public function setNbJustificatifs(int $nbJustificatifs): static
    {
        $this->nbJustificatifs = $nbJustificatifs;

        return $this;
    }

    public function getMontantValid(): ?string
    {
        return $this->montantValid;
    }

    public function setMontantValid(string $montantValid): static
    {
        $this->montantValid = $montantValid;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, LigneFraisHorsForfait>
     */
    public function getLigneFraisHorsForfait(): Collection
    {
        return $this->LigneFraisHorsForfait;
    }

    public function addLigneFraisHorsForfait(LigneFraisHorsForfait $ligneFraisHorsForfait): static
    {
        if (!$this->LigneFraisHorsForfait->contains($ligneFraisHorsForfait)) {
            $this->LigneFraisHorsForfait->add($ligneFraisHorsForfait);
            $ligneFraisHorsForfait->setFicheFrais($this);
        }

        return $this;
    }

    public function removeLigneFraisHorsForfait(LigneFraisHorsForfait $ligneFraisHorsForfait): static
    {
        if ($this->LigneFraisHorsForfait->removeElement($ligneFraisHorsForfait)) {
            // set the owning side to null (unless already changed)
            if ($ligneFraisHorsForfait->getFicheFrais() === $this) {
                $ligneFraisHorsForfait->setFicheFrais(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, LigneFraisForfait>
     */
    public function getLigneFraisForfait(): Collection
    {
        return $this->ligneFraisForfait;
    }

    public function addLigneFraisForfait(LigneFraisForfait $ligneFraisForfait): static
    {
        if (!$this->ligneFraisForfait->contains($ligneFraisForfait)) {
            $this->ligneFraisForfait->add($ligneFraisForfait);
            $ligneFraisForfait->setFicheFrais($this);
        }

        return $this;
    }

    public function removeLigneFraisForfait(LigneFraisForfait $ligneFraisForfait): static
    {
        if ($this->ligneFraisForfait->removeElement($ligneFraisForfait)) {
            // set the owning side to null (unless already changed)
            if ($ligneFraisForfait->getFicheFrais() === $this) {
                $ligneFraisForfait->setFicheFrais(null);
            }
        }

        return $this;
    }

    public function getDateModif(): ?\DateTimeInterface
    {
        return $this->dateModif;
    }

    public function setDateModif(\DateTimeInterface $dateModif): static
    {
        $this->dateModif = $dateModif;

        return $this;
    }

    public function montantAllFicheFraisByUSer(): int
    {
        $allLigneForfait = $this->ligneFraisForfait;
        $allLigneForfaitByUser = new ArrayCollection();
        $montant = 0;

        foreach ($allLigneForfait as $fiche) {
            if($fiche->getFicheFrais()->getUser()->getId() == $this->getUser()->getId()){
                $allLigneForfaitByUser->add($fiche);
            }
        }

        foreach ($allLigneForfaitByUser as $ligneForfaitUser){
                $montant += $ligneForfaitUser->getQuantite() * $ligneForfaitUser->getFraisForfait()->getMontant();

        }

        return $montant;
    }

    public function montantAllFicheFraisHorsForfaitByUSer(): int
    {
        $allLigneHorsForfait = $this->getLigneFraisHorsForfait();
        $allLigneHorsForfaitByUser = new ArrayCollection();
        $montant = 0;

        foreach ($allLigneHorsForfait as $fiche) {
            if($fiche->getFicheFrais()->getUser()->getId() == $this->getUser()->getId()){
                $allLigneHorsForfaitByUser->add($fiche);
            }
        }

        foreach ($allLigneHorsForfaitByUser as $ligneHorsForfaitUser){
            $montant += $ligneHorsForfaitUser->getMontant();
        }

        return $montant;
    }
}
