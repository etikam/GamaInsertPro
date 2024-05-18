<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, ResponsableEntreprise>
     */
    #[ORM\ManyToMany(targetEntity: ResponsableEntreprise::class, inversedBy: 'entreprises')]
    private Collection $idResponsable;

    /**
     * @var Collection<int, OffreEntreprise>
     */
    #[ORM\ManyToMany(targetEntity: OffreEntreprise::class, inversedBy: 'entreprises')]
    private Collection $idOffreEntreprise;

    /**
     * @var Collection<int, ProfilRecherche>
     */
    #[ORM\ManyToMany(targetEntity: ProfilRecherche::class, inversedBy: 'entreprises')]
    private Collection $idProfilRecherche;

    public function __construct()
    {
        $this->idResponsable = new ArrayCollection();
        $this->idOffreEntreprise = new ArrayCollection();
        $this->idProfilRecherche = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, ResponsableEntreprise>
     */
    public function getIdResponsable(): Collection
    {
        return $this->idResponsable;
    }

    public function addIdResponsable(ResponsableEntreprise $idResponsable): static
    {
        if (!$this->idResponsable->contains($idResponsable)) {
            $this->idResponsable->add($idResponsable);
        }

        return $this;
    }

    public function removeIdResponsable(ResponsableEntreprise $idResponsable): static
    {
        $this->idResponsable->removeElement($idResponsable);

        return $this;
    }

    /**
     * @return Collection<int, OffreEntreprise>
     */
    public function getIdOffreEntreprise(): Collection
    {
        return $this->idOffreEntreprise;
    }

    public function addIdOffreEntreprise(OffreEntreprise $idOffreEntreprise): static
    {
        if (!$this->idOffreEntreprise->contains($idOffreEntreprise)) {
            $this->idOffreEntreprise->add($idOffreEntreprise);
        }

        return $this;
    }

    public function removeIdOffreEntreprise(OffreEntreprise $idOffreEntreprise): static
    {
        $this->idOffreEntreprise->removeElement($idOffreEntreprise);

        return $this;
    }

    /**
     * @return Collection<int, ProfilRecherche>
     */
    public function getIdProfilRecherche(): Collection
    {
        return $this->idProfilRecherche;
    }

    public function addIdProfilRecherche(ProfilRecherche $idProfilRecherche): static
    {
        if (!$this->idProfilRecherche->contains($idProfilRecherche)) {
            $this->idProfilRecherche->add($idProfilRecherche);
        }

        return $this;
    }

    public function removeIdProfilRecherche(ProfilRecherche $idProfilRecherche): static
    {
        $this->idProfilRecherche->removeElement($idProfilRecherche);

        return $this;
    }
}
