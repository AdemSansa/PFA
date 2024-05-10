<?php

namespace App\Entity;

use App\Repository\CPRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CPRepository::class)]
class CP
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    

    #[ORM\ManyToOne(inversedBy: 'ID_CP')]
    private ?Commandes $COM = null;

    #[ORM\ManyToMany(targetEntity: livre::class)]
    private Collection $LIV;

    public function __construct()
    {
        $this->LIV = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

   

   

    public function getCOM(): ?Commandes
    {
        return $this->COM;
    }

    public function setCOM(?Commandes $COM): static
    {
        $this->COM = $COM;

        return $this;
    }

    /**
     * @return Collection<int, livre>
     */
    public function getLIV(): Collection
    {
        return $this->LIV;
    }

    public function addLIV(livre $lIV): static
    {
        if (!$this->LIV->contains($lIV)) {
            $this->LIV->add($lIV);
        }

        return $this;
    }

    public function removeLIV(livre $lIV): static
    {
        $this->LIV->removeElement($lIV);

        return $this;
    }
}
