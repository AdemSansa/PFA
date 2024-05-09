<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ID_client = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $Date_CommandeAt = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $detailCommande = [];

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column(length: 255)]
    private ?string $Status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIDClient(): ?int
    {
        return $this->ID_client;
    }

    public function setIDClient(int $ID_client): static
    {
        $this->ID_client = $ID_client;

        return $this;
    }

    public function getDateCommandeAt(): ?\DateTimeImmutable
    {
        return $this->Date_CommandeAt;
    }

    public function setDateCommandeAt(\DateTimeImmutable $Date_CommandeAt): static
    {
        $this->Date_CommandeAt = $Date_CommandeAt;

        return $this;
    }

    public function getDetailCommande(): array
    {
        return $this->detailCommande;
    }

    public function setDetailCommande(array $detailCommande): static
    {
        $this->detailCommande = $detailCommande;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): static
    {
        $this->Status = $Status;

        return $this;
    }
}
