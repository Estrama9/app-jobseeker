<?php

namespace App\Entity;

use App\Enum\EducationLevel;
use App\Enum\ExperienceLevel;
use App\Enum\Gender;
use App\Enum\StatusCandidate;
use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata as Api;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: CandidateRepository::class)]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['read_candidate']],
    denormalizationContext: ['groups' => ['write_candidate']],
    // security: 'is_granted("ROLE_USER") and is_granted("ROLE_CANDIDATE")'
)]
#[Api\GetCollection()]
#[Api\Get()]
class Candidate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 2000)]
    private ?string $biography = null;

    #[ORM\Column(enumType: Gender::class)]
    private ?Gender $gender = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $birthday = null;

    #[ORM\Column(enumType: EducationLevel::class)]
    private ?EducationLevel $educationLevel = null;

    #[ORM\Column(enumType: ExperienceLevel::class)]
    private ?ExperienceLevel $experienceLevel = null;

    #[ORM\Column(enumType: StatusCandidate::class)]
    private ?StatusCandidate $statusCandidate = null;

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

    /**
     * @var Collection<int, Application>
     */
    #[ORM\OneToMany(targetEntity: Application::class, mappedBy: 'candidate', cascade: ['remove'])]
    private Collection $applications;

    #[ORM\OneToOne(inversedBy: 'candidate', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->statusCandidate = StatusCandidate::OPEN_TO_WORK;
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): static
    {
        $this->biography = $biography;

        return $this;
    }

    public function getStatusCandidate(): ?StatusCandidate
    {
        return $this->statusCandidate;
    }

    public function setStatusCandidate(StatusCandidate $statusCandidate): static
    {
        $this->statusCandidate = $statusCandidate;

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

    public function getYoutube(): ?string
    {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): static
    {
        $this->youtube = $youtube;

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
            $application->setCandidate($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): static
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getCandidate() === $this) {
                $application->setCandidate(null);
            }
        }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthday(): ?\DateTimeImmutable
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeImmutable $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getUser(); // Assuming getUser() returns the User entity
    }

}
