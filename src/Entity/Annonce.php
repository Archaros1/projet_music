<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnonceRepository")
 */
class Annonce
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_event;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $genre_event;

    /**
     * @ORM\Column(type="date")
     */
    private $date_begin;

    /**
     * @ORM\Column(type="date")
     */
    private $date_end;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offre", mappedBy="annonce")
     */
    private $offres;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu", inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lieu;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Style", inversedBy="annonces")
     */
    private $style_recherche;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventType", inversedBy="annonces")
     * @ORM\JoinColumn(nullable=true)
     */
    private $type_event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisateur", inversedBy="annonces")
     */
    private $organisateur;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
        $this->style_recherche = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEvent(): ?string
    {
        return $this->nom_event;
    }

    public function setNomEvent(string $nom_event): self
    {
        $this->nom_event = $nom_event;

        return $this;
    }

    public function getGenreEvent(): ?string
    {
        return $this->genre_event;
    }

    public function setGenreEvent(string $genre_event): self
    {
        $this->genre_event = $genre_event;

        return $this;
    }

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->date_begin;
    }

    public function setDateBegin(\DateTimeInterface $date_begin): self
    {
        $this->date_begin = $date_begin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Offre[]
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;
            $offre->setAnnonce($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->contains($offre)) {
            $this->offres->removeElement($offre);
            // set the owning side to null (unless already changed)
            if ($offre->getAnnonce() === $this) {
                $offre->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection|Style[]
     */
    public function getStyleRecherche(): Collection
    {
        return $this->style_recherche;
    }

    public function addStyleRecherche(Style $styleRecherche): self
    {
        if (!$this->style_recherche->contains($styleRecherche)) {
            $this->style_recherche[] = $styleRecherche;
        }

        return $this;
    }

    public function removeStyleRecherche(Style $styleRecherche): self
    {
        if ($this->style_recherche->contains($styleRecherche)) {
            $this->style_recherche->removeElement($styleRecherche);
        }

        return $this;
    }

    public function getTypeEvent(): ?EventType
    {
        return $this->type_event;
    }

    public function setTypeEvent(?EventType $type_event): self
    {
        $this->type_event = $type_event;

        return $this;
    }

    public function getOrganisateur(): ?Organisateur
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?Organisateur $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }
}
