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
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pw;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Contact", inversedBy="organisateur", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Annonce", mappedBy="organisateur")
     */
    private $annonces;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OrganisateurType", inversedBy="organisateurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Avis", mappedBy="organisateur", cascade={"persist", "remove"})
     */
    private $avis;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPw(): ?string
    {
        return $this->pw;
    }

    public function setPw(string $pw): self
    {
        $this->pw = $pw;

        return $this;
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

    public function getAvis(): ?Avis
    {
        return $this->avis;
    }

    public function setAvis(Avis $avis): self
    {
        $this->avis = $avis;

        // set the owning side of the relation if necessary
        if ($avis->getOrganisateur() !== $this) {
            $avis->setOrganisateur($this);
        }

        return $this;
    }

}
