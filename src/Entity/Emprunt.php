<?php

namespace App\Entity;

use App\Repository\EmpruntRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpruntRepository::class)
 */
class Emprunt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEmp;

    /**
     * @ORM\Column(type="date")
     */
    private $dateRet;

    /**
     * @ORM\ManyToOne(targetEntity=Adherent::class, inversedBy="livreEmprunt")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adherent;

    /**
     * @ORM\ManyToOne(targetEntity=Livres::class, inversedBy="pret")
     * @ORM\JoinColumn(nullable=false)
     */
    private $emprunts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEmp(): ?\DateTimeInterface
    {
        return $this->dateEmp;
    }

    public function setDateEmp(\DateTimeInterface $dateEmp): self
    {
        $this->dateEmp = $dateEmp;

        return $this;
    }

    public function getDateRet(): ?\DateTimeInterface
    {
        return $this->dateRet;
    }

    public function setDateRet(\DateTimeInterface $dateRet): self
    {
        $this->dateRet = $dateRet;

        return $this;
    }

    public function getAdherent(): ?Adherent
    {
        return $this->adherent;
    }

    public function setAdherent(?Adherent $adherent): self
    {
        $this->adherent = $adherent;

        return $this;
    }

    public function getEmprunts(): ?Livres
    {
        return $this->emprunts;
    }

    public function setEmprunts(?Livres $emprunts): self
    {
        $this->emprunts = $emprunts;

        return $this;
    }
}
