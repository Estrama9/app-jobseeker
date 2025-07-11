<?php

namespace App\Entity;

use App\Enum\City;
use App\Enum\Industry;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata as Api;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['read_company']],
    denormalizationContext: ['groups' => ['write_company']],
)]
#[Api\GetCollection()]
#[Api\Get()]
class Company
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Api\ApiProperty(identifier:false)]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_company', 'write_company', 'read_job', 'read_application'])]
    private ?string $name = null;

    #[ORM\Column(length: 2000)]
    #[Groups(['read_company', 'write_company'])]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(enumType: City::class)]
    private ?City $city = null;

    #[ORM\Column(nullable: true)]
    private ?int $teamSize = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $establishmentDate = null;

    #[ORM\Column(enumType: Industry::class)]
    private ?Industry $industry = null;

    #[ORM\Column(length: 255)]
    private ?string $logoUrl = null;

    #[ORM\Column(length: 255)]
    private ?string $website = null;

    #[ORM\Column(length: 255)]
    private ?string $linkedin = null;

    #[ORM\Column(length: 255)]
    private ?string $github = null;

    #[ORM\Column(length: 255)]
    private ?string $x = null;

    #[ORM\Column(length: 255)]
    private ?string $instagram = null;

    #[ORM\Column(length: 255)]
    private ?string $facebook = null;

     #[ORM\Column(length: 255)]
    private ?string $youtube = null;

    #[ORM\ManyToOne(inversedBy: 'companies')]
    #[Groups(['read_company', 'write_company', 'read_application' ])]
    private ?User $user = null;

    /**
     * @var Collection<int, Job>
     */
    #[ORM\OneToMany(targetEntity: Job::class, mappedBy: 'company', cascade: ['remove'])]
    private Collection $jobs;

    #[ORM\Column(length: 128, unique: true)]
    #[Gedmo\Slug(fields: ['name'])]
    #[Groups(['read_company', 'read_job'])]
    #[Api\ApiProperty(identifier:true)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(City $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getTeamSize(): ?int
    {
        return $this->teamSize;
    }

    public function setTeamSize(int $teamSize): static
    {
        $this->teamSize = $teamSize;

        return $this;
    }

    public function getEstablishmentDate(): ?\DateTimeImmutable
    {
        return $this->establishmentDate;
    }

    public function setEstablishmentDate(\DateTimeImmutable $establishmentDate): static
    {
        $this->establishmentDate = $establishmentDate;

        return $this;
    }

    public function getIndustry(): ?Industry
    {
        return $this->industry;
    }

    public function setIndustry(Industry $industry): static
    {
        $this->industry = $industry;

        return $this;
    }

    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    public function setLogoUrl(?string $logoUrl): static
    {
        $this->logoUrl = $logoUrl;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): static
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(?string $github): static
    {
        $this->github = $github;

        return $this;
    }

    public function getX(): ?string
    {
        return $this->x;
    }

    public function setX(?string $x): static
    {
        $this->x = $x;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): static
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): static
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Job>
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(Job $job): static
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs->add($job);
            $job->setCompany($this);
        }

        return $this;
    }

    public function removeJob(Job $job): static
    {
        if ($this->jobs->removeElement($job)) {
            // set the owning side to null (unless already changed)
            if ($job->getCompany() === $this) {
                $job->setCompany(null);
            }
        }

        return $this;
    }

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(string $youtube): static
    {
        $this->youtube = $youtube;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName(); // or any string property that represents the company
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
