<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Enum\City;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata as Api;
use App\Controller\Api\MeAction;
use App\Enum\UserRole;
use Symfony\Component\Serializer\Attribute\Groups;
use App\Entity\Company;
use ApiPlatform\OpenApi\Model;
use App\DataPersister\UserEmailVerification;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[Api\ApiResource(
    normalizationContext: ['groups' => ['read_user']],
    denormalizationContext: ['groups' => ['write_user']],
)]

#[Api\Get(
    uriTemplate: '/me',
    security: 'is_granted("ROLE_USER")',
    controller: MeAction::class,
    read: false,
    openapi: new Model\Operation(
        summary: 'Show current user profile'
    )
)]


#[Api\GetCollection(
    security: 'is_granted("ROLE_ADMIN")',
    securityMessage: 'Only admins can list users.'
)]

#[Api\Post(
    processor: UserEmailVerification::class,
    security:'true' // accessible à tous pour créer un utilisateur

)]
#[Api\Patch(
    security: 'object == user',
    securityMessage: 'You can only edit your own profile.'
)]
#[Api\Delete(
    security: 'is_granted("ROLE_ADMIN") or object == user',
    securityMessage: 'You can delete yourself or must be admin to delete others.'
)]
#[Api\ApiFilter(SearchFilter::class, properties:['fullname' => 'ipartial'])]
#[Api\ApiFilter(OrderFilter::class, properties:['fullname'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['read_user', 'write_user', 'read_candidate'])]
    private ?string $email = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

     #[Groups(['write_user'])]
    private ?string $plainPassword = null;

    #[Groups(['read_user', 'write_user'])]
    #[ORM\Column(type: 'json')]
    private array $roles = [UserRole::USER->value];


    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read_user', 'write_user', 'read_candidate', 'read_company', 'read_application'])]
    private ?string $fullname = null;

     #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = 'France';

    #[ORM\Column(enumType: City::class, nullable: true)]
    private ?City $city = null;

    // #[ORM\Column(enumType: Entitlement::class, nullable: true)]
    // private ?Entitlement $entitlement = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?string $resetToken = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $resetTokenExpiresAt = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Candidate $candidate = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Company::class, cascade: ['persist', 'remove'])]
    private ?Company $company = null;

    #[ORM\Column]
    private bool $isVerified = false;

    public function __construct()
    {
        $now = new \DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
        // $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    // public function getRoles(): array
    // {
    //     $roles = $this->roles;

    //     // Toujours inclure ROLE_USER
    //     if (!in_array('ROLE_USER', $roles, true)) {
    //         $roles[] = 'ROLE_USER';
    //     }

    //     return array_unique($roles);
    // }

    // public function setRoles(array $roles): static
    // {
    //     // Toujours forcer ROLE_USER
    //     if (!in_array('ROLE_USER', $roles, true)) {
    //         $roles[] = 'ROLE_USER';
    //     }

    //     $this->roles = array_unique($roles);
    //     return $this;
    // }

        /**
     * @return string[]
     */
    public function getRoles(): array
    {
        $roleStrings = $this->roles;

        // Toujours inclure ROLE_USER
        if (!in_array(UserRole::USER->value, $roleStrings, true)) {
            $roleStrings[] = UserRole::USER->value;
        }

        return array_unique($roleStrings);
    }


        /**
     * @param array<UserRole|string> $roles
     */
    public function setRoles(array $roles): static
    {
        $enumRoles = array_map(function ($role) {
            if (is_string($role)) {
                return UserRole::from($role);
            }

            if ($role instanceof UserRole) {
                return $role;
            }

            throw new \InvalidArgumentException('Invalid role type.');
        }, $roles);

        $roleValues = array_map(fn(UserRole $role) => $role->value, $enumRoles);

        if (!in_array(UserRole::USER->value, $roleValues, true)) {
            $roleValues[] = UserRole::USER->value;
        }

        $this->roles = array_unique($roleValues);
        return $this;
    }



    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullname;
    }

    public function setFullName(string $fullname): static
    {
        $this->fullname = $fullname;

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

    // public function getEntitlement(): ?Entitlement
    // {
    //     return $this->entitlement;
    // }

    // public function setEntitlement(Entitlement $entitlement): static
    // {
    //     $this->entitlement = $entitlement;

    //     return $this;
    // }

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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        // unset the owning side of the relation if necessary
    if ($company === null && $this->company !== null) {
        $this->company->setUser(null);
    }

    // set the owning side of the relation if necessary
    if ($company !== null && $company->getUser() !== $this) {
        $company->setUser($this);
    }

    $this->company = $company;

    return $this;
}

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidate $candidate): static
    {
        // unset the owning side of the relation if necessary
        if ($candidate === null && $this->candidate !== null) {
            $this->candidate->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($candidate !== null && $candidate->getUser() !== $this) {
            $candidate->setUser($this);
        }

        $this->candidate = $candidate;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        $this->setUpdatedAt(new \DateTimeImmutable());

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
        return $this->getEmail(); // or $this->getUsername() or any string representation
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getResetToken(): ?string { return $this->resetToken; }
    public function setResetToken(?string $token): static { $this->resetToken = $token; return $this; }

    public function getResetTokenExpiresAt(): ?\DateTimeInterface { return $this->resetTokenExpiresAt; }
    public function setResetTokenExpiresAt(?\DateTimeInterface $date): static { $this->resetTokenExpiresAt = $date; return $this; }

}
