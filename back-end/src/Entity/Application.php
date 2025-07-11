<?php

namespace App\Entity;

use App\Enum\StatusApplication;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata as Api;
use App\Doctrine\OwnerableInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['read_application']],
    denormalizationContext: ['groups' => ['write_application']],
    security: 'is_granted("ROLE_USER")'
)]
#[Api\GetCollection()]
#[Api\Get()]
#[Api\Get()]
class Application implements OwnerableInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read_application', 'write_application'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $cv = null;

    #[ORM\Column(length: 255)]
    private ?string $coverLetter = null;

    #[ORM\Column(enumType: StatusApplication::class)]
    private ?StatusApplication $statusApplication = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    private ?Candidate $candidate = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[Groups(['read_application'])]
    private ?Job $job = null;

    public function __construct()
    {
        $now = new \DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
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

    public function setUser(User $user): void
{
    if ($this->getCandidate()) {
        $this->getCandidate()->setUser($user);
        return;
    }

    if ($this->getJob()?->getCompany()) {
        $this->getJob()->getCompany()->setUser($user);
    }
}


    public function getUser(): ?User
{
    if ($this->getCandidate()) {
        return $this->getCandidate()->getUser(); // if Candidate wraps a User
    }

    if ($this->getJob() && $this->getJob()->getCompany()->getUser()) {
        return $this->getJob()->getCompany()->getUser(); // assuming Job has getEmployer(): ?User
    }

    return null;
}



}
