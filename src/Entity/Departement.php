<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementRepository::class)]
class Departement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'departements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Faculte $fk_faculte = null;

    /**
     * @var Collection<int, Concentration>
     */
    #[ORM\OneToMany(targetEntity: Concentration::class, mappedBy: 'fk_departement')]
    private Collection $concentrations;
    private Collection $etudiants;

    public function __construct()
    {
        $this->concentrations = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getFkFaculte(): ?Faculte
    {
        return $this->fk_faculte;
    }

    public function setFkFaculte(?Faculte $fk_faculte): static
    {
        $this->fk_faculte = $fk_faculte;

        return $this;
    }

    /**
     * @return Collection<int, Concentration>
     */
    public function getConcentrations(): Collection
    {
        return $this->concentrations;
    }

    public function addConcentration(Concentration $concentration): static
    {
        if (!$this->concentrations->contains($concentration)) {
            $this->concentrations->add($concentration);
            $concentration->setFkDepartement($this);
        }

        return $this;
    }

    public function removeConcentration(Concentration $concentration): static
    {
        if ($this->concentrations->removeElement($concentration)) {
            // set the owning side to null (unless already changed)
            if ($concentration->getFkDepartement() === $this) {
                $concentration->setFkDepartement(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection<int, Etudiant>
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): static
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants->add($etudiant);
            $etudiant->setDepartement($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): static
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getDepartement() === $this) {
                $etudiant->setDepartement(null);
            }
        }

        return $this;
    }

}
