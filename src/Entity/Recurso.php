<?php

namespace App\Entity;

use App\Repository\RecursoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: RecursoRepository::class)]
#[UniqueEntity(fields: ['nombre'], message: 'Ya existe un recurso con este nombre.')]
class Recurso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Assert\NotBlank(message: 'El nombre no puede estar vacío.')]
    private ?string $nombre = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 50)]
    private ?string $tipo = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    /**
     * @var Collection<int, Llave>
     */
    #[ORM\ManyToMany(targetEntity: Llave::class, mappedBy: 'recursos')]
    private Collection $llaves;

    public function __construct()
    {
        $this->llaves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

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

    /**
     * @return Collection<int, Llave>
     */
    public function getLlaves(): Collection
    {
        return $this->llaves;
    }

    public function addLlave(Llave $llave): static
    {
        if (!$this->llaves->contains($llave)) {
            $this->llaves->add($llave);
            $llave->addRecurso($this);
        }

        return $this;
    }

    public function removeLlave(Llave $llave): static
    {
        if ($this->llaves->removeElement($llave)) {
            $llave->removeRecurso($this);
        }

        return $this;
    }
}
