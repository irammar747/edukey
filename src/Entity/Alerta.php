<?php

namespace App\Entity;

use App\Repository\AlertaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlertaRepository::class)]
class Alerta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'alertas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prestamo $prestamo = null;

    #[ORM\ManyToOne(inversedBy: 'alertas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TipoAlerta $tipoAlerta = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fecha = null;

    #[ORM\Column(length: 50, options: ['default' => 'pendiente'])]
    private ?string $estado = 'pendiente';

    public function __construct()
    {
        // Esto equivale al DEFAULT CURRENT_TIMESTAMP de la base de datos
        $this->fecha = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrestamo(): ?Prestamo
    {
        return $this->prestamo;
    }

    public function setPrestamo(?Prestamo $prestamo): static
    {
        $this->prestamo = $prestamo;

        return $this;
    }

    public function getTipoAlerta(): ?TipoAlerta
    {
        return $this->tipoAlerta;
    }

    public function setTipoAlerta(?TipoAlerta $tipoAlerta): static
    {
        $this->tipoAlerta = $tipoAlerta;

        return $this;
    }

    public function getFecha(): ?\DateTimeImmutable
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeImmutable $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): static
    {
        $this->estado = $estado;

        return $this;
    }
}
