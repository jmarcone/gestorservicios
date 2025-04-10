<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource(
    operations: [
        new Delete(),
        new Get(
            normalizationContext: ['groups' => ['casa:read', 'casa:details']],
            denormalizationContext: ['groups' => ['casa:write']]
        ),
        new Put(),
        new GetCollection(),
        new Post()
    ],
    inputFormats: ['multipart' => ['application/ld+json']],
    outputFormats: ['jsonld' => ['application/ld+json']],
    normalizationContext: ['groups' => ['casa:read']],
    denormalizationContext: ['groups' => ['casa:write']]
)]
class Casa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ApiProperty(iris: ["https://schema.org/name"])]
    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['casa:read', 'casa:write'])]
    private string $direccion;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Groups(['casa:read', 'casa:write'])]
    private ?string $propietario = null;

    #[ORM\OneToMany(targetEntity: Factura::class, mappedBy: "casa", cascade: ["persist", "remove"])]
    #[Groups(['casa:read'])]
    private Collection $facturas;

    #[ApiProperty(readable: true)]
    #[Groups(['casa:details'])]
    private array $servicios;

    public function getServicios(): array
    {
        $servicios = [];
        foreach ($this->getFacturas() as $factura) {
            $serviceName = $factura->getServicio()->getNombre();
            if (!array_key_exists($serviceName, $servicios)) {
                $servicios[$serviceName] = ['facturas' => [], 'deuda' => 0];
            }

            if ($factura->getIsPaid()) {
                continue;
            }
            $servicios[$serviceName]['facturas'][] = $factura;
            $servicios[$serviceName]['deuda'] += $factura->getSaldo();
        }
        return $servicios;
    }



    public function __construct()
    {
        $this->facturas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;
        return $this;
    }

    public function getPropietario(): ?string
    {
        return $this->propietario;
    }

    public function setPropietario(?string $propietario): self
    {
        $this->propietario = $propietario;
        return $this;
    }

    /**
     * @return Collection|Factura[]
     */
    public function getFacturas(): Collection
    {
        return $this->facturas;
    }

    public function addFactura(Factura $factura): self
    {
        if (!$this->facturas->contains($factura)) {
            $this->facturas[] = $factura;
            $factura->setCasa($this);
        }
        return $this;
    }

    public function removeFactura(Factura $factura): self
    {
        if ($this->facturas->removeElement($factura)) {
            if ($factura->getCasa() === $this) {
                $factura->setCasa(null);
            }
        }
        return $this;
    }
}
