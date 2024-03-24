<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[ORM\Table(name: 'companys')]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $cnpj = null;

    #[ORM\Column(length: 255)]
    private ?string $sector = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToMany(targetEntity: Partner::class, mappedBy: 'companies')]
    private Collection $partners;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompanyObservation", mappedBy="company", orphanRemoval=true)
     */
    private Collection $companyObservations;

    public function __construct()
    {
        $this->partners = new ArrayCollection();
        $this->companyObservations = new ArrayCollection();
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

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): static
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    public function getSector(): ?string
    {
        return $this->sector;
    }

    public function setSector(string $sector): static
    {
        $this->sector = $sector;

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
     * @return Collection<int, Partner>
     */
    public function getPartner(): Collection
    {
        return $this->partners;
    }

    public function addPartner(Partner $partner): static
    {
        if (!$this->partners->contains($partner)) {
            $this->partners->add($partner);
        }

        return $this;
    }

    public function removePartner(Partner $partner): static
    {
        $this->partners->removeElement($partner);

        return $this;
    }

    /**
     * @return Collection<int, CompanyObservation>
     */
    public function getCompanyObservations(): Collection
    {
        return $this->companyObservations;
    }

    public function addCompanyObservation(CompanyObservation $companyObservation): static
    {
        if (!$this->companyObservations->contains($companyObservation)) {
            $this->companyObservations->add($companyObservation);
            $companyObservation->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyObservation(CompanyObservation $companyObservation): static
    {
        if ($this->companyObservations->removeElement($companyObservation)) {
            // set the owning side to null (unless already changed)
            if ($companyObservation->getCompany() === $this) {
                $companyObservation->setCompany(null);
            }
        }

        return $this;
    }
}
