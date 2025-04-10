<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\FacturaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: FacturaRepository::class)]
#[ApiResource(
    operations: [
        new Delete(),
        new Get(
            normalizationContext: ['groups' => ['factura:read', 'factura:details']],
            denormalizationContext: ['groups' => ['factura:write']]
        ),
        new Put(),
        new GetCollection(),
        new Post(
        ),
    ],
    inputFormats: [
        'multipart' => ['multipart/form-data'],
        'jsonld' => ['application/ld+json']
    ],
    outputFormats: ['jsonld' => ['application/ld+json']],
    normalizationContext: ['groups' => ['factura:read']],
    denormalizationContext: ['groups' => ['factura:write']]
)]
class Factura
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Casa::class, inversedBy: "facturas")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['factura:write', 'factura:read'])]
    private ?Casa $casa = null;

    #[ORM\ManyToOne(targetEntity: Servicio::class, inversedBy: "facturas")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['factura:write', 'factura:read'])]
    private ?Servicio $servicio = null;

    #[ORM\Column(type: "datetime")]
    #[Groups(['factura:write', 'factura:read'])]
    private \DateTimeInterface $fechaEmision;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    #[Groups(['factura:write', 'factura:read', 'casa:details'])]
    private float $monto;

    #[ORM\OneToMany(targetEntity: Pago::class, mappedBy: "factura", cascade: ["persist", "remove"])]
    #[Groups(['factura:write', 'factura:read'])]
    private Collection $pagos;

    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['factura:read'])]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(
        mapping: 'factura_file',
        fileNameProperty: 'filePath',
    )]
    #[Groups(['factura:write',])]
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    public function __construct()
    {
        $this->pagos = new ArrayCollection();
        $this->fechaEmision = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCasa(): ?Casa
    {
        return $this->casa;
    }

    public function setCasa(?Casa $casa): self
    {
        $this->casa = $casa;
        return $this;
    }

    public function getServicio(): ?Servicio
    {
        return $this->servicio;
    }

    public function setServicio(?Servicio $servicio): self
    {
        $this->servicio = $servicio;
        return $this;
    }

    public function getFechaEmision(): \DateTimeInterface
    {
        return $this->fechaEmision;
    }

    public function setFechaEmision(\DateTimeInterface $fechaEmision): self
    {
        $this->fechaEmision = $fechaEmision;
        return $this;
    }

    public function getMonto(): float
    {
        return $this->monto;
    }

    public function setMonto(float $monto): self
    {
        $this->monto = $monto;
        return $this;
    }

    /**
     * @return Collection|Pago[]
     */
    public function getPagos(): Collection
    {
        return $this->pagos;
    }

    public function addPago(Pago $pago): self
    {
        if (!$this->pagos->contains($pago)) {
            $this->pagos[] = $pago;
            $pago->setFactura($this);
        }
        return $this;
    }

    public function removePago(Pago $pago): self
    {
        if ($this->pagos->removeElement($pago)) {
            if ($pago->getFactura() === $this) {
                $pago->setFactura(null);
            }
        }
        return $this;
    }

    #[ApiProperty(iris: ["https://schema.org/name"])]
    #[Groups(['factura:read'])]
    public function getDisplayName(): string
    {
        return "{$this->casa->getDireccion()} - {$this->getServicio()->getNombre()} - {$this->getFechaEmision()->format("d-m-Y")}";
    }


    #[Groups(['factura:read', 'casa:details'])]
    public function getSaldo(): float
    {
        $pagos = 0.0;
        foreach ($this->getPagos() as $pago) {
            $pagos += $pago->getMonto();
        }

        return $this->monto - $pagos;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): static
    {
        $this->filePath = $filePath;

        return $this;
    }

    #[Groups(['factura:read', 'casa:details'])]
    public function getIsPaid(): bool
    {
        return $this->getSaldo() <= 0;
    }

}
