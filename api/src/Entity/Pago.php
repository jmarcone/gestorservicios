<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    inputFormats: [
        'multipart' => ['multipart/form-data'],
        'jsonld' => ['application/ld+json']
    ],
    outputFormats: ['jsonld' => ['application/ld+json']],
)]
class Pago
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:"integer")]
    #[Groups(['factura:details'])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Factura::class, inversedBy: "pagos")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Factura $factura = null;

    #[ORM\Column(type:"datetime")]
    #[Groups(['factura:details'])]
    private \DateTimeInterface $fechaPago;

    #[ORM\Column(type:"decimal", precision: 10, scale: 2)]
    #[Groups(['factura:details'])]
    private float $monto;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFactura(): ?Factura
    {
        return $this->factura;
    }

    public function setFactura(?Factura $factura): self
    {
        $this->factura = $factura;
        return $this;
    }

    public function getFechaPago(): \DateTimeInterface
    {
        return $this->fechaPago;
    }

    public function setFechaPago(\DateTimeInterface $fechaPago): self
    {
        $this->fechaPago = $fechaPago;
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

    #[ApiProperty(iris: ["https://schema.org/name"])]
    public function getDisplayName(): string
    {
        return "{$this->factura->getDisplayName()} {$this->fechaPago->format("d-m-Y")}";
    }
}
