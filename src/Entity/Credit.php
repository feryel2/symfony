<?php

namespace App\Entity;

use App\Repository\CreditRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $Montant = null;

    #[ORM\Column]
    private ?float $MontantEmprunte = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateDemande = null;

    #[ORM\Column]
    private ?float $TauxInteret = null;

    #[ORM\Column]
    private ?int $NbMois = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateEmission = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateEcheance = null;

    #[ORM\Column]
    private ?bool $Status = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\OneToMany(mappedBy: 'Credit', targetEntity: Remboursement::class, orphanRemoval: true)]
    private Collection $Remboursements;

    #[ORM\Column(length: 255)]
    private ?string $Type = null;

    public function __construct()
    {
        $this->Remboursements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(float $Montant): static
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getMontantEmprunte(): ?float
    {
        return $this->MontantEmprunte;
    }

    public function setMontantEmprunte(float $MontantEmprunte): static
    {
        $this->MontantEmprunte = $MontantEmprunte;

        return $this;
    }

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->DateDemande;
    }

    public function setDateDemande(\DateTimeInterface $DateDemande): static
    {
        $this->DateDemande = $DateDemande;

        return $this;
    }

    public function getTauxInteret(): ?float
    {
        return $this->TauxInteret;
    }

    public function setTauxInteret(float $TauxInteret): static
    {
        $this->TauxInteret = $TauxInteret;

        return $this;
    }

    public function getNbMois(): ?int
    {
        return $this->NbMois;
    }

    public function setNbMois(int $NbMois): static
    {
        $this->NbMois = $NbMois;

        return $this;
    }

    public function getDateEmission(): ?\DateTimeInterface
    {
        return $this->DateEmission;
    }

    public function setDateEmission(\DateTimeInterface $DateEmission): static
    {
        $this->DateEmission = $DateEmission;

        return $this;
    }

    public function getDateEcheance(): ?\DateTimeInterface
    {
        return $this->DateEcheance;
    }

    public function setDateEcheance(\DateTimeInterface $DateEcheance): static
    {
        $this->DateEcheance = $DateEcheance;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->Status;
    }

    public function setStatus(bool $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Remboursement>
     */
    public function getRemboursements(): Collection
    {
        return $this->Remboursements;
    }

    public function addRemboursement(Remboursement $remboursement): static
    {
        if (!$this->Remboursements->contains($remboursement)) {
            $this->Remboursements->add($remboursement);
            $remboursement->setCredit($this);
        }

        return $this;
    }

    public function removeRemboursement(Remboursement $remboursement): static
    {
        if ($this->Remboursements->removeElement($remboursement)) {
            // set the owning side to null (unless already changed)
            if ($remboursement->getCredit() === $this) {
                $remboursement->setCredit(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }
}
