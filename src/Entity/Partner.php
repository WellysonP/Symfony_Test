<?php

namespace App\Entity;

use App\Repository\PartnerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartnerRepository::class)]
#[ORM\Table(name: 'partners')]
class Partner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PartnerObservation", mappedBy="partner", orphanRemoval=true)
     */
    private Collection $partnerObservations;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $cpf = null;

    #[ORM\ManyToMany(targetEntity: Company::class, inversedBy: 'partners')]
    private Collection $companies;

    public function __construct()
    {
        $this->partnerObservations = new ArrayCollection();
        $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
    /**
     * @return Collection<int, PartnerObservation>
     */
    public function getPartnerObservations(): Collection
    {
        return $this->partnerObservations;
    }

    public function addPartnerObservation(PartnerObservation $partnerObservation): static
    {
        if (!$this->partnerObservations->contains($partnerObservation)) {
            $this->partnerObservations->add($partnerObservation);
            $partnerObservation->setPartner($this);
        }

        return $this;
    }

    public function removePartnerObservation(PartnerObservation $partnerObservation): static
    {
        if ($this->partnerObservations->removeElement($partnerObservation)) {
            // set the owning side to null (unless already changed)
            if ($partnerObservation->getPartner() === $this) {
                $partnerObservation->setPartner(null);
            }
        }

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): static
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    // public function addCompany(Company $company): static
    // {
    //     if (!$this->companies->contains($company)) {
    //         $this->companies->add($company);
    //         $company->addPartner($this);
    //     }

    //     return $this;
    // }

    // public function removeCompany(Company $company): static
    // {
    //     if ($this->companies->removeElement($company)) {
    //         $company->removePartner($this);
    //     }

    //     return $this;
    // }
}
