<?php

namespace App\Entity;

use App\Repository\PostulationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostulationRepository::class)]
class Postulation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePostulation = null;

    /**
     * @var Collection<int, Etudiant>
     */
    #[ORM\OneToMany(targetEntity: Etudiant::class, mappedBy: 'postulation')]
    private Collection $fk_etudiant;

    /**
     * @var Collection<int, Offre>
     */
    #[ORM\ManyToMany(targetEntity: Offre::class)]
    private Collection $fk_offre;

    /**
     * @var Collection<int, Document>
     */
    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'fk_postulation')]
    private Collection $documents;

    public function __construct()
    {
        $this->fk_etudiant = new ArrayCollection();
        $this->fk_offre = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePostulation(): ?\DateTimeInterface
    {
        return $this->datePostulation;
    }

    public function setDatePostulation(\DateTimeInterface $datePostulation): static
    {
        $this->datePostulation = $datePostulation;

        return $this;
    }

    /**
     * @return Collection<int, Etudiant>
     */
    public function getFkEtudiant(): Collection
    {
        return $this->fk_etudiant;
    }

    public function addFkEtudiant(Etudiant $fkEtudiant): static
    {
        if (!$this->fk_etudiant->contains($fkEtudiant)) {
            $this->fk_etudiant->add($fkEtudiant);
            $fkEtudiant->setPostulation($this);
        }

        return $this;
    }

    public function removeFkEtudiant(Etudiant $fkEtudiant): static
    {
        if ($this->fk_etudiant->removeElement($fkEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($fkEtudiant->getPostulation() === $this) {
                $fkEtudiant->setPostulation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Offre>
     */
    public function getFkOffre(): Collection
    {
        return $this->fk_offre;
    }

    public function addFkOffre(Offre $fkOffre): static
    {
        if (!$this->fk_offre->contains($fkOffre)) {
            $this->fk_offre->add($fkOffre);
        }

        return $this;
    }

    public function removeFkOffre(Offre $fkOffre): static
    {
        $this->fk_offre->removeElement($fkOffre);

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): static
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setFkPostulation($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): static
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getFkPostulation() === $this) {
                $document->setFkPostulation(null);
            }
        }

        return $this;
    }
}
