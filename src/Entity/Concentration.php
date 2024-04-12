<?php

namespace App\Entity;

use App\Repository\ConcentrationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConcentrationRepository::class)]
class Concentration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'concentrations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Departement $fk_departement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getFkDepartement(): ?Departement
    {
        return $this->fk_departement;
    }

    public function setFkDepartement(?Departement $fk_departement): static
    {
        $this->fk_departement = $fk_departement;

        return $this;
    }
}
