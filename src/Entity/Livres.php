<?php

namespace App\Entity;

use App\Repository\LivresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivresRepository::class)
 */
class Livres
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $auteur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disponible;

    /**
     * @ORM\OneToMany(targetEntity=Emprunt::class, mappedBy="emprunts", orphanRemoval=true)
     */
    private $pret;

    public function __construct()
    {
        $this->pret = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * @return Collection|Emprunt[]
     */
    public function getPret(): Collection
    {
        return $this->pret;
    }

    public function addPret(Emprunt $pret): self
    {
        if (!$this->pret->contains($pret)) {
            $this->pret[] = $pret;
            $pret->setEmprunts($this);
        }

        return $this;
    }

    public function removePret(Emprunt $pret): self
    {
        if ($this->pret->removeElement($pret)) {
            // set the owning side to null (unless already changed)
            if ($pret->getEmprunts() === $this) {
                $pret->setEmprunts(null);
            }
        }

        return $this;
    }
}
