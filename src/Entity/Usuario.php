<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[UniqueEntity(fields: ['username'], message: 'Este nombre de usuario ya está registrado en EduKey.')]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 50)]
    private ?string $apellido1 = null;

    #[ORM\Column(length: 50)]
    private ?string $apellido2 = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'El correo es obligatorio')]
    #[Assert\Email(
        message: 'El correo "{{ value }}" no es un formato válido.'
    )]
    private ?string $email = null;

    #[ORM\Column(length: 15, nullable: true)]
    #[Assert\Regex(
        pattern: '/^[0-9]+$/',
        message: 'El teléfono solo puede contener números o el símbolo +.'
    )]
    #[Assert\Length(
        min: 9,
        max: 9,
        exactMessage: 'El teléfono debe tener {{ limit }} dígitos.'
    )]
    private ?string $telefono = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    #[ORM\ManyToOne(inversedBy: 'usuarios')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Departamento $departamento = null;

    /**
     * @var Collection<int, Prestamo>
     */
    #[ORM\OneToMany(targetEntity: Prestamo::class, mappedBy: 'docente')]
    private Collection $prestamosSolicitados;

    /**
     * @var Collection<int, Prestamo>
     */
    #[ORM\OneToMany(targetEntity: Prestamo::class, mappedBy: 'personal')]
    private Collection $prestamosRegistrados;

    public function __construct()
    {
        $this->prestamosSolicitados = new ArrayCollection();
        $this->prestamosRegistrados = new ArrayCollection();
        $this->roles = [];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

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
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido1(): ?string
    {
        return $this->apellido1;
    }

    public function setApellido1(string $apellido1): static
    {
        $this->apellido1 = $apellido1;

        return $this;
    }

    public function getApellido2(): ?string
    {
        return $this->apellido2;
    }

    public function setApellido2(string $apellido2): static
    {
        $this->apellido2 = $apellido2;

        return $this;
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

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getDepartamento(): ?Departamento
    {
        return $this->departamento;
    }

    public function setDepartamento(?Departamento $departamento): static
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * @return Collection<int, Prestamo>
     */
    public function getPrestamosSolicitados(): Collection
    {
        return $this->prestamosSolicitados;
    }

    public function addPrestamosSolicitado(Prestamo $prestamosSolicitado): static
    {
        if (!$this->prestamosSolicitados->contains($prestamosSolicitado)) {
            $this->prestamosSolicitados->add($prestamosSolicitado);
            $prestamosSolicitado->setDocente($this);
        }

        return $this;
    }

    public function removePrestamosSolicitado(Prestamo $prestamosSolicitado): static
    {
        if ($this->prestamosSolicitados->removeElement($prestamosSolicitado)) {
            // set the owning side to null (unless already changed)
            if ($prestamosSolicitado->getDocente() === $this) {
                $prestamosSolicitado->setDocente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Prestamo>
     */
    public function getPrestamosRegistrados(): Collection
    {
        return $this->prestamosRegistrados;
    }

    public function addPrestamosRegistrado(Prestamo $prestamosRegistrado): static
    {
        if (!$this->prestamosRegistrados->contains($prestamosRegistrado)) {
            $this->prestamosRegistrados->add($prestamosRegistrado);
            $prestamosRegistrado->setPersonal($this);
        }

        return $this;
    }

    public function removePrestamosRegistrado(Prestamo $prestamosRegistrado): static
    {
        if ($this->prestamosRegistrados->removeElement($prestamosRegistrado)) {
            // set the owning side to null (unless already changed)
            if ($prestamosRegistrado->getPersonal() === $this) {
                $prestamosRegistrado->setPersonal(null);
            }
        }

        return $this;
    }
}
