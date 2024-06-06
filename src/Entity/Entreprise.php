<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $prenom = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 100)]
    private ?string $nomEntreprise = null;

    #[ORM\Column(length: 100)]
    private ?string $telephone = null;

    /**
     * @var Collection<int, TypeOffre>
     */
    #[ORM\ManyToMany(targetEntity: TypeOffre::class, inversedBy: 'entreprises')]
    private Collection $fk_type_offre;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateLimite = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 100)]
    private ?string $taille = null;

    #[ORM\Column(length: 100)]
    private ?string $domaine = null;

    #[ORM\Column(length: 100)]
    private ?string $lieu = null;

    #[ORM\Column(length: 100)]
    private ?string $experience = null;

    #[ORM\Column(length: 100)]
    private ?string $competence = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $emailResponsable = null;

    #[ORM\Column(length: 50)]
    private ?string $telResponsable = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $domaineRecherche = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEnvoi = null;

    #[ORM\Column(length: 50)]
    private ?string $niveauRecherche = null;

    #[ORM\Column]
    private ?bool $statut = null;

    public function __construct()
    {
        $this->fk_type_offre = new ArrayCollection();
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): static
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return Collection<int, TypeOffre>
     */
    public function getFkTypeOffre(): Collection
    {
        return $this->fk_type_offre;
    }

    public function addFkTypeOffre(TypeOffre $fkTypeOffre): static
    {
        if (!$this->fk_type_offre->contains($fkTypeOffre)) {
            $this->fk_type_offre->add($fkTypeOffre);
        }

        return $this;
    }

    public function removeFkTypeOffre(TypeOffre $fkTypeOffre): static
    {
        $this->fk_type_offre->removeElement($fkTypeOffre);

        return $this;
    }

    public function getDateLimite(): ?\DateTimeInterface
    {
        return $this->dateLimite;
    }

    public function setDateLimite(\DateTimeInterface $dateLimite): static
    {
        $this->dateLimite = $dateLimite;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): static
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(string $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function getCompetence(): ?string
    {
        return $this->competence;
    }

    public function setCompetence(string $competence): static
    {
        $this->competence = $competence;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getEmailResponsable(): ?string
    {
        return $this->emailResponsable;
    }

    public function setEmailResponsable(?string $emailResponsable): static
    {
        $this->emailResponsable = $emailResponsable;

        return $this;
    }

    public function getTelResponsable(): ?string
    {
        return $this->telResponsable;
    }

    public function setTelResponsable(string $telResponsable): static
    {
        $this->telResponsable = $telResponsable;

        return $this;
    }

    public function getDomaineRecherche(): ?string
    {
        return $this->domaineRecherche;
    }

    public function setDomaineRecherche(?string $domaineRecherche): static
    {
        $this->domaineRecherche = $domaineRecherche;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): static
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getNiveauRecherche(): ?string
    {
        return $this->niveauRecherche;
    }

    public function setNiveauRecherche(string $niveauRecherche): static
    {
        $this->niveauRecherche = $niveauRecherche;

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): static
    {
        $this->statut = $statut;

        return $this;
    }
}
