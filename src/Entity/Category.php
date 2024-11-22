<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, trick>
     */
    #[ORM\OneToMany(targetEntity: trick::class, mappedBy: 'category', orphanRemoval: true)]
    private Collection $trick;

    public function __construct()
    {
        $this->trick = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, trick>
     */
    public function getTrick(): Collection
    {
        return $this->trick;
    }

    public function addTrick(trick $trick): static
    {
        if (!$this->trick->contains($trick)) {
            $this->trick->add($trick);
            $trick->setCategory($this);
        }

        return $this;
    }

    public function removeTrick(trick $trick): static
    {
        if ($this->trick->removeElement($trick)) {
            // set the owning side to null (unless already changed)
            if ($trick->getCategory() === $this) {
                $trick->setCategory(null);
            }
        }

        return $this;
    }
}
