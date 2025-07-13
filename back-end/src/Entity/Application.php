<?php

namespace App\Entity;

use App\Enum\StatusApplication;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata as Api;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['read_application']],
    denormalizationContext: ['groups' => ['write_application']],
    security: 'is_granted("ROLE_USER")'
)]
#[Api\GetCollection()]
#[Api\Get(security: ' is_granted("ROLE_ADMIN") or object.getJob().getCompany().getUser() == user or object.getCandidate().getUser() == user',
    securityMessage: 'Only the candidates himselfs or the employers himselfs or ADMIN can access this data.')]
#[Api\Post(
    security: 'is_granted("ROLE_CANDIDATE")',
    securityMessage: 'Only the candidates can add data.')]
#[Api\Post(
)]
#[Api\Patch(
    security: 'object.getCandidate().getUser() == user',
    securityMessage: 'Only the candidates himselfs can modify data.'
)]
#[Api\Delete(
    security: 'is_granted("ROLE_ADMIN") or object.getCandidate().getUser() == user',
    securityMessage: 'Only the candidates himselfs and the Admin can delete data.'
)]
#[UniqueEntity(
    fields: ['candidate', 'job'],
    message: 'You have already applied to this job.'
)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_application', 'write_application'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cv = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coverLetter = null;

    #[ORM\Column(enumType: StatusApplication::class)]
    private ?StatusApplication $statusApplication = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?Candidate $candidate = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[Groups(['read_application', 'write_application'])]
    private ?Job $job = null;

    public function __construct()
    {
        $now = new \DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
        $this->statusApplication = StatusApplication::ACTIVE;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatusApplication(): ?StatusApplication
    {
        return $this->statusApplication;
    }

    public function setStatusApplication(StatusApplication $statusApplication): static
    {
        $this->statusApplication = $statusApplication;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidate $candidate): static
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $titre): static
    {
        $this->title = $titre;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(?string $cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    public function getCoverLetter(): ?string
    {
        return $this->coverLetter;
    }

    public function setCoverLetter(?string $coverLetter): static
    {
        $this->coverLetter = $coverLetter;

        return $this;
    }

    // public function setUser(User $user): void
    // {
    //     if ($this->getCandidate()) {
    //         $this->getCandidate()->setUser($user);
    //         return;
    //     }

    //     if ($this->getJob()?->getCompany()) {
    //         $this->getJob()->getCompany()->setUser($user);
    //     }
    // }


    // public function getUser(): ?User
    // {
    //     if ($this->getCandidate()) {
    //         return $this->getCandidate()->getUser(); // if Candidate wraps a User
    //     }

    //     if ($this->getJob() && $this->getJob()->getCompany()->getUser()) {
    //         return $this->getJob()->getCompany()->getUser(); // assuming Job has getEmployer(): ?User
    //     }

    //     return null;
    // }



}
