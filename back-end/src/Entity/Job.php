<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Enum\City;
use App\Enum\EducationLevel;
use App\Enum\ExperienceLevel;
use App\Enum\JobType;
use App\Enum\StatusJob;
use App\Enum\WorkMode;
use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata as Api;
use Symfony\Component\Serializer\Attribute\Groups;


#[ORM\Entity(repositoryClass: JobRepository::class)]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['read_job']],
    denormalizationContext: ['groups' => ['write_job']],
    security: 'is_granted("PUBLIC_ACCESS")'
)]
#[Api\GetCollection(
    security: "is_granted('PUBLIC_ACCESS')",
    forceEager: false
)]
#[Api\Get(
    security: 'is_granted("ROLE_CANDIDATE") or object.getCompany().getUser() == user',
    securityMessage: 'Only the employer himself can access this data.',
    forceEager: false
)]
#[Api\Post(
    security: 'is_granted("ROLE_EMPLOYER")',
    securityMessage: 'Only the users with ROLE_EMPLOYER can add this data.'
)]
#[Api\Patch(
    security: 'object.getCompany().getUser() == user',
    securityMessage: 'Only the employer himself can update this data.'
)]
#[Api\Delete(
    security: 'is_granted("ROLE_ADMIN") or object.getCompany().getUser() == user',
    securityMessage: 'Only the employer himself or an admin can delete this data.'
)]

// #[Api\ApiFilter(SearchFilter::class, properties:['company.name' => 'exact'])]
// #[Api\ApiFilter(SearchFilter::class, properties:['company.name' => 'ipartial'])]
#[Api\ApiFilter(SearchFilter::class, properties:['company.slug' => 'ipartial'])]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read_job'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_job', 'write_job'])]
    private ?string $title = null;

    #[ORM\Column(length: 2000)]
    private ?string $description = null;

     #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[Groups(['read_job'])]
    #[ORM\Column(enumType: City::class, nullable: true)]
    private ?City $city = null;

    #[Groups(['read_job'])]
    #[ORM\Column(enumType: JobType::class , nullable: true)]
    private ?JobType $jobType = null;

    #[ORM\Column(enumType: WorkMode::class , nullable: true)]
    private ?WorkMode $workMode = null;

    #[ORM\Column(enumType: StatusJob::class , nullable: true)]
    private ?StatusJob $statusJob = null;

    #[Groups(['read_job'])]
    #[ORM\Column(nullable: true)]
    private ?int $minSalary = null;

    #[Groups(['read_job'])]
    #[ORM\Column(nullable: true)]
    private ?int $maxSalary = null;

    #[ORM\Column(enumType: EducationLevel::class , nullable: true)]
    private ?EducationLevel $educationLevel = null;

    #[ORM\Column(enumType: ExperienceLevel::class , nullable: true)]
    private ?ExperienceLevel $experienceLevel = null;

    #[ORM\Column(nullable: true)]
    private ?int $hiringLimit = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $expirationDate = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Application>
     */
    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'job' , cascade: ['remove'])]
    private Collection $applications;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'jobs')]
    #[Groups(['read_application', 'read_job'])]
    private ?Company $company = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->applications = new ArrayCollection();
        $this->country = 'France';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

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

    public function getJobType(): ?JobType
    {
        return $this->jobType;
    }

    public function setJobType(JobType $jobType): static
    {
        $this->jobType = $jobType;

        return $this;
    }

    public function getWorkMode(): ?WorkMode
    {
        return $this->workMode;
    }

    public function setWorkMode(WorkMode $workMode): static
    {
        $this->workMode = $workMode;

        return $this;
    }

    public function getStatusJob(): ?StatusJob
    {
        return $this->statusJob;
    }

    public function setStatusJob(StatusJob $statusJob): static
    {
        $this->statusJob = $statusJob;

        return $this;
    }

    public function getMinSalary(): ?int
    {
        return $this->minSalary;
    }

    public function setMinSalary(int $minSalary): static
    {
        $this->minSalary = $minSalary;

        return $this;
    }

    public function getMaxSalary(): ?int
    {
        return $this->maxSalary;
    }

    public function setMaxSalary(int $maxSalary): static
    {
        $this->maxSalary = $maxSalary;

        return $this;
    }

    public function getEducationLevel(): ?EducationLevel
    {
        return $this->educationLevel;
    }

    public function setEducationLevel(EducationLevel $educationLevel): static
    {
        $this->educationLevel = $educationLevel;

        return $this;
    }

    public function getExperienceLevel(): ?ExperienceLevel
    {
        return $this->experienceLevel;
    }

    public function setExperienceLevel(ExperienceLevel $experienceLevel): static
    {
        $this->experienceLevel = $experienceLevel;

        return $this;
    }

    public function getHiringLimit(): ?int
    {
        return $this->hiringLimit;
    }

    public function setHiringLimit(int $hiringLimit): static
    {
        $this->hiringLimit = $hiringLimit;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeImmutable
    {
        return $this->expirationDate;
    }

    public function setExpirationDate(\DateTimeImmutable $expirationDate): static
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): static
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setJob($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getJob() === $this) {
                $application->setJob(null);
            }
        }

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

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

    public function __toString(): string
    {
        return $this->getTitle();
    }


//     public function setUser(User $user): void
//     {
//         if ($this->getCompany()) {
//             $this->getCompany()->setUser($user);
//             return;
//         }

//         if ($this?->getCompany()) {
//             $this->getCompany()->setUser($user);
//         }
//     }


//     public function getUser(): ?User
//     {
//         if ($this->getCompany()) {
//             return $this->getCompany()->getUser(); // if Candidate wraps a User
//         }

//         if ($this->getCompany() && $this->getCompany()->getUser()) {
//             return $this->getCompany()->getUser(); // assuming Job has getEmployer(): ?User
//         }

//         return null;
//     }

public function getCountry(): ?string
{
    return $this->country;
}

public function setCountry(?string $country): static
{
    $this->country = $country;

    return $this;
}
}
