<?php

namespace App\Entity;

use App\Repository\PlatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlatRepository::class)]
class Plat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $libelle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $prix = null;

    #[ORM\Column(length: 50)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'plat')]
    #[ORM\JoinColumn(nullable: false)] // Nullable=false pour rendre la catégorie obligatoire
    private ?Categorie $categories = null;

    /**
     * @var Collection<int, Detail>
     */
    #[ORM\OneToMany(targetEntity: Detail::class, mappedBy: 'plats')]
    private Collection $detail;

    public function __construct()
    {
        $this->detail = new ArrayCollection();
    }

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getCategories(): ?Categorie
    {
        return $this->categories;
    }

    public function setCategories(?Categorie $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection<int, Detail>
     */
    public function getDetail(): Collection
    {
        return $this->detail;
    }

    public function addDetail(Detail $detail): static
    {
        if (!$this->detail->contains($detail)) {
            $this->detail->add($detail);
            $detail->setPlats($this);
        }

        return $this;
    }

    public function removeDetail(Detail $detail): static
    {
        if ($this->detail->removeElement($detail)) {
            // Set the owning side to null (unless already changed)
            if ($detail->getPlats() === $this) {
                $detail->setPlats(null);
            }
        }

        return $this;
    }
}
