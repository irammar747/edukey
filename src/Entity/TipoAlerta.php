<?php

namespace App\Entity;

use App\Repository\TipoAlertaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TipoAlertaRepository::class)]
#[UniqueEntity(fields: ['nombre'], message: 'Ya existe un tipo de alerta con este nombre.')]
class TipoAlerta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $nombre = null;

    #[ORM\Column(length: 250)]
    private ?string $mensaje = null;

    #[ORM\Column(length: 20)]
    private ?string $gravedad = null;

    #[ORM\Column(length: 50)]
    private ?string $consecuencia = null;

    /**
     * @var Collection<int, Alerta>
     */
    #[ORM\OneToMany(targetEntity: Alerta::class, mappedBy: 'tipoAlerta')]
    private Collection $alertas;

    public function __construct()
    {
        $this->alertas = new ArrayCollection();
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

    public function getMensaje(): ?string
    {
        return $this->mensaje;
    }

    public function setMensaje(string $mensaje): static
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    public function getGravedad(): ?string
    {
        return $this->gravedad;
    }

    public function setGravedad(string $gravedad): static
    {
        $this->gravedad = $gravedad;

        return $this;
    }

    public function getConsecuencia(): ?string
    {
        return $this->consecuencia;
    }

    public function setConsecuencia(string $consecuencia): static
    {
        $this->consecuencia = $consecuencia;

        return $this;
    }

    /**
     * @return Collection<int, Alerta>
     */
    public function getAlertas(): Collection
    {
        return $this->alertas;
    }

    public function addAlerta(Alerta $alerta): static
    {
        if (!$this->alertas->contains($alerta)) {
            $this->alertas->add($alerta);
            $alerta->setTipoAlerta($this);
        }

        return $this;
    }

    public function removeAlerta(Alerta $alerta): static
    {
        if ($this->alertas->removeElement($alerta)) {
            // set the owning side to null (unless already changed)
            if ($alerta->getTipoAlerta() === $this) {
                $alerta->setTipoAlerta(null);
            }
        }

        return $this;
    }
}
