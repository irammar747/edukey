<?php

namespace App\Entity;

use App\Repository\PrestamoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestamoRepository::class)]
class Prestamo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'prestamos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Llave $llave = null;

    #[ORM\ManyToOne(inversedBy: 'prestamosSolicitados')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $docente = null;

    #[ORM\ManyToOne(inversedBy: 'prestamosRegistrados')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $personal = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $f_prest = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $f_devo = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $tiempo_lim = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $observaciones = null;

    /**
     * @var Collection<int, Alerta>
     */
    #[ORM\OneToMany(targetEntity: Alerta::class, mappedBy: 'prestamo')]
    private Collection $alertas;

    public function __construct()
    {
        // Esto equivale al DEFAULT CURRENT_TIMESTAMP de la base de datos
        $this->f_prest = new \DateTimeImmutable();
        $this->alertas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLlave(): ?Llave
    {
        return $this->llave;
    }

    public function setLlave(?Llave $llave): static
    {
        $this->llave = $llave;

        return $this;
    }

    public function getDocente(): ?Usuario
    {
        return $this->docente;
    }

    public function setDocente(?Usuario $docente): static
    {
        $this->docente = $docente;

        return $this;
    }

    public function getPersonal(): ?Usuario
    {
        return $this->personal;
    }

    public function setPersonal(?Usuario $personal): static
    {
        $this->personal = $personal;

        return $this;
    }

    public function getFPrest(): ?\DateTimeImmutable
    {
        return $this->f_prest;
    }

    public function setFPrest(\DateTimeImmutable $f_prest): static
    {
        $this->f_prest = $f_prest;

        return $this;
    }

    public function getFDevo(): ?\DateTimeImmutable
    {
        return $this->f_devo;
    }

    public function setFDevo(?\DateTimeImmutable $f_devo): static
    {
        $this->f_devo = $f_devo;

        return $this;
    }

    public function getTiempoLim(): ?\DateTimeImmutable
    {
        return $this->tiempo_lim;
    }

    public function setTiempoLim(?\DateTimeImmutable $tiempo_lim): static
    {
        $this->tiempo_lim = $tiempo_lim;

        return $this;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): static
    {
        $this->observaciones = $observaciones;

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
            $alerta->setPrestamo($this);
        }

        return $this;
    }

    public function removeAlerta(Alerta $alerta): static
    {
        if ($this->alertas->removeElement($alerta)) {
            // set the owning side to null (unless already changed)
            if ($alerta->getPrestamo() === $this) {
                $alerta->setPrestamo(null);
            }
        }

        return $this;
    }
}
