<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\Traits\Identifier;
use App\Enum\UserGender;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource(
    normalizationContext: [
        'groups' => ['user.read'],
    ],
    denormalizationContext: [
        'groups' => ['user.write'],
    ],
    mercure: true
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use Identifier;

    public const string USER_ROLE = 'ROLE_USER';
    public const string ADMIN_ROLE = 'ROLE_ADMIN';

    #[Groups(['user.read', 'user.write'])]
    #[ORM\Column(type: 'string', length: 10, enumType: UserGender::class)]
    private UserGender $gender;

    #[ORM\Column(length: 255)]
    #[Groups(['user.read', 'user.write'])]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user.read', 'user.write'])]
    private ?string $lastName = null;

    #[Groups(['user.read', 'user.write'])]
    #[ORM\Column(length: 180)]
    private string $email = 'john.doe@example.com';

    /**
     * @var list<string> The user roles
     */
    #[Groups(['user.read', 'user.write'])]
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string|null The hashed password
     */
    #[Groups(['user.read', 'user.write'])]
    #[ORM\Column]
    private ?string $password = null;

    #[Groups(['user.read', 'user.write'])]
    #[ORM\Column]
    private bool $isVerified = false;

    private ?string $verificationToken = null;

    /**
     * @var Collection<int, Address>
     */
    #[ORM\ManyToMany(targetEntity: Address::class, inversedBy: 'occupant')]
    #[Groups(['user.read', 'user.write'])]
    private Collection $address;

    public function __construct()
    {
        $this->address = new ArrayCollection();
    }

    public function getGender(): UserGender
    {
        return $this->gender;
    }

    public function setGender(UserGender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }


    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string The user identifier, typically the email
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @return list<string>
     *
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles = []): static
    {
        $roles[] = self::USER_ROLE;
        $unique = array_unique($roles);
        $this->roles = array_values($unique);

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

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getVerificationToken(): ?string
    {
        return $this->verificationToken;
    }

    public function setVerificationToken(?string $token): void
    {
        $this->verificationToken = $token;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): static
    {
        if (!$this->address->contains($address)) {
            $this->address->add($address);
        }

        return $this;
    }

    public function removeAddress(Address $address): static
    {
        $this->address->removeElement($address);

        return $this;
    }

}
