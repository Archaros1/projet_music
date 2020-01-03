<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fb;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Groupe", mappedBy="contacts", cascade={"persist", "remove"})
     */
    private $groupe;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Organisateur", mappedBy="contacts", cascade={"persist", "remove"})
     */
    private $organisateur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Annonce", mappedBy="contacts", cascade={"persist", "remove"})
     */
    private $annonce;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Event", mappedBy="contacts", cascade={"persist", "remove"})
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getFb(): ?string
    {
        return $this->fb;
    }

    public function setFb(?string $fb): self
    {
        $this->fb = $fb;

        return $this;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(Groupe $groupe): self
    {
        $this->groupe = $groupe;

        // set the owning side of the relation if necessary
        if ($groupe->getContacts() !== $this) {
            $groupe->setContacts($this);
        }

        return $this;
    }

    public function getOrganisateur(): ?Organisateur
    {
        return $this->organisateur;
    }

    public function setOrganisateur(Organisateur $organisateur): self
    {
        $this->organisateur = $organisateur;

        // set the owning side of the relation if necessary
        if ($organisateur->getContacts() !== $this) {
            $organisateur->setContacts($this);
        }

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(Annonce $annonce): self
    {
        $this->annonce = $annonce;

        // set the owning side of the relation if necessary
        if ($annonce->getContacts() !== $this) {
            $annonce->setContacts($this);
        }

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): self
    {
        $this->event = $event;

        // set the owning side of the relation if necessary
        if ($event->getContacts() !== $this) {
            $event->setContacts($this);
        }

        return $this;
    }
}
