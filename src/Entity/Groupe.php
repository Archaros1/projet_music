<?php

namespace App\Entity;

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
     * @ORM\Column(type="string", length=255)
     */
    private $pw;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

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

    public function getPw(): ?string
    {
        return $this->pw;
    }

    public function setPw(string $pw): self
    {
        $this->pw = $pw;

        return $this;
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
}
