<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupeRepository")
 */
class Groupe
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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombre_membre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $a_domicile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $a_tout_son_materiel;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contact", inversedBy="groupe", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offre", mappedBy="groupe")
     */
    private $offres;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Event", mappedBy="groupes")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Musicien", mappedBy="groupes")
     */
    private $musiciens;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Style", inversedBy="groupes")
     */
    private $style;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="groupe")
     */
    private $photos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GroupeType", inversedBy="groupes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="groupe", cascade={"persist", "remove"})
     */
    private $avis;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Account", mappedBy="groupe", cascade={"persist", "remove"})
     */
    private $account;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->musiciens = new ArrayCollection();
        $this->style = new ArrayCollection();
        $this->photos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNombreMembre(): ?int
    {
        return $this->nombre_membre;
    }

    public function setNombreMembre(int $nombre_membre): self
    {
        $this->nombre_membre = $nombre_membre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getADomicile(): ?bool
    {
        return $this->a_domicile;
    }

    public function setADomicile(bool $a_domicile): self
    {
        $this->a_domicile = $a_domicile;

        return $this;
    }

    public function getAToutSonMateriel(): ?bool
    {
        return $this->a_tout_son_materiel;
    }

    public function setAToutSonMateriel(bool $a_tout_son_materiel): self
    {
        $this->a_tout_son_materiel = $a_tout_son_materiel;

        return $this;
    }

    public function getContacts(): ?Contact
    {
        return $this->contacts;
    }

    public function setContacts(Contact $contacts): self
    {
        $this->contacts = $contacts;

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
            $offre->setGroupe($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->contains($offre)) {
            $this->offres->removeElement($offre);
            // set the owning side to null (unless already changed)
            if ($offre->getGroupe() === $this) {
                $offre->setGroupe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addGroupe($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            $event->removeGroupe($this);
        }

        return $this;
    }

    /**
     * @return Collection|Musicien[]
     */
    public function getMusiciens(): Collection
    {
        return $this->musiciens;
    }

    public function addMusicien(Musicien $musicien): self
    {
        if (!$this->musiciens->contains($musicien)) {
            $this->musiciens[] = $musicien;
            $musicien->addGroupe($this);
        }

        return $this;
    }

    public function removeMusicien(Musicien $musicien): self
    {
        if ($this->musiciens->contains($musicien)) {
            $this->musiciens->removeElement($musicien);
            $musicien->removeGroupe($this);
        }

        return $this;
    }

    /**
     * @return Collection|Style[]
     */
    public function getStyle(): Collection
    {
        return $this->style;
    }

    public function addStyle(Style $style): self
    {
        if (!$this->style->contains($style)) {
            $this->style[] = $style;
        }

        return $this;
    }

    public function removeStyle(Style $style): self
    {
        if ($this->style->contains($style)) {
            $this->style->removeElement($style);
        }

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setGroupe($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getGroupe() === $this) {
                $photo->setGroupe(null);
            }
        }

        return $this;
    }

    public function getType(): ?GroupeType
    {
        return $this->type;
    }

    public function setType(?GroupeType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAvis(): ?Avis
    {
        return $this->avis;
    }

    public function setAvis(Avis $avis): self
    {
        $this->avis = $avis;

        // set the owning side of the relation if necessary
        if ($avis->getGroupe() !== $this) {
            $avis->setGroupe($this);
        }

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        // set (or unset) the owning side of the relation if necessary
        $newGroupe = null === $account ? null : $this;
        if ($account->getGroupe() !== $newGroupe) {
            $account->setGroupe($newGroupe);
        }

        return $this;
    }
}
