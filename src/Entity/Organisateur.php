<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganisateurRepository")
 */
class Organisateur
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
     * @ORM\OneToMany(targetEntity="App\Entity\Annonce", mappedBy="organisateur", cascade={"persist", "remove"})
     */
    private $annonces;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OrganisateurType", inversedBy="organisateurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Account", mappedBy="organisateur", cascade={"persist", "remove"})
     */
    private $account;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="organisateur", orphanRemoval=false)
     */
    private $events;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->events = new ArrayCollection();
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

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setOrganisateur($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->contains($annonce)) {
            $this->annonces->removeElement($annonce);
            // set the owning side to null (unless already changed)
            if ($annonce->getOrganisateur() === $this) {
                $annonce->setOrganisateur(null);
            }
        }

        return $this;
    }

    public function getType(): ?OrganisateurType
    {
        return $this->type;
    }

    public function setType(?OrganisateurType $type): self
    {
        $this->type = $type;

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
        $newOrganisateur = null === $account ? null : $this;
        if ($account->getOrganisateur() !== $newOrganisateur) {
            $account->setOrganisateur($newOrganisateur);
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
            $event->setOrganisateur($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getOrganisateur() === $this) {
                $event->setOrganisateur(null);
            }
        }

        return $this;
    }

}
