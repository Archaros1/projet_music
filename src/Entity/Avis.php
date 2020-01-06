<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvisRepository")
 */
class Avis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groupe", inversedBy="avis", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Organisateur", inversedBy="avis", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $organisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $caller;

    /**
     * @ORM\Column(type="integer")
     */
    private $note;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupe(): ?Groupe
    {
        return $this->groupe;
    }

    public function setGroupe(Groupe $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getOrganisateur(): ?Organisateur
    {
        return $this->organisateur;
    }

    public function setOrganisateur(Organisateur $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    public function getCaller(): ?string
    {
        return $this->caller;
    }

    public function setCaller(string $caller): self
    {
        $this->caller = $caller;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
