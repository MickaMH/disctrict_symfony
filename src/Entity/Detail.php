<?php

namespace App\Entity;

use App\Repository\DetailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailRepository::class)]
class Detail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\ManyToOne(inversedBy: 'detail')]
    private ?Plat $plats = null;

    #[ORM\ManyToOne(inversedBy: 'details')]
    private ?Commande $commande = null;

    /**
     * @ORM\ManyToOne(targetEntity=Plat::class, inversedBy="details")
     */
    private $plat;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $adresse_facturation = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $cp_facturation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ville_facturation = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $adresse_livraison = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $cp_livraison = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ville_livraison = null;

    #[ORM\Column(type: Types::INTEGER)]
    private $commande_id;

    #[ORM\Column(type: Types::INTEGER)]
    private $plats_id;

    // ...

public function getCommandeId(): ?int
{
    return $this->commande_id;
}

public function setCommandeId(int $commande_id): self
{
    $this->commande_id = $commande_id;

    return $this;
}

public function getPlatsId(): ?int
{
    return $this->plats_id;
}

public function setPlatsId(int $plats_id): self
{
    $this->plats_id = $plats_id;

    return $this;
}

    public function getPlat(): ?Plat
    {
        return $this->plat;
    }

    public function setPlat(?Plat $plat): self
    {
        $this->plat = $plat;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPlats(): ?Plat
    {
        return $this->plats;
    }

    public function setPlats(?Plat $plats): static
    {
        $this->plats = $plats;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }

    public function getAdresseFacturation(): ?string
    {
        return $this->adresse_facturation;
    }

    public function setAdresseFacturation(?string $adresse_facturation): static
    {
        $this->adresse_facturation = $adresse_facturation;

        return $this;
    }

    public function getCpFacturation(): ?string
    {
        return $this->cp_facturation;
    }

    public function setCpFacturation(?string $cp_facturation): static
    {
        $this->cp_facturation = $cp_facturation;

        return $this;
    }

    public function getVilleFacturation(): ?string
    {
        return $this->ville_facturation;
    }

    public function setVilleFacturation(?string $ville_facturation): static
    {
        $this->ville_facturation = $ville_facturation;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresse_livraison;
    }

    public function setAdresseLivraison(?string $adresse_livraison): static
    {
        $this->adresse_livraison = $adresse_livraison;

        return $this;
    }

    public function getCpLivraison(): ?string
    {
        return $this->cp_livraison;
    }

    public function setCpLivraison(?string $cp_livraison): static
    {
        $this->cp_livraison = $cp_livraison;

        return $this;
    }

    public function getVilleLivraison(): ?string
    {
        return $this->ville_livraison;
    }

    public function setVilleLivraison(?string $ville_livraison): static
    {
        $this->ville_livraison = $ville_livraison;

        return $this;
    }
}
