<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 20)]
    private ?string $telephone = null;

    #[ORM\Column(length: 50)]
    private ?string $adresse = null;

    #[ORM\Column(length: 20)]
    private ?string $cp = null;

    #[ORM\Column(length: 50)]
    private ?string $ville = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'utilisateur')]
    private Collection $commandes;

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

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        /* // Vérifiez la longueur du nom (30 caractères maximum)
        if (strlen($nom) > 30) {
            throw new \InvalidArgumentException('Le nom doit contenir au maximum 30 caractères.');
        }

        // Vérifiez la regex
        if (!preg_match('/^[a-zA-Z][a-zA-Z\' -]{1,30}$/', $nom)) {
            throw new \InvalidArgumentException('Le nom est incorrect.');
        } */

        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        /* // Vérifiez la longueur du nom (30 caractères maximum)
        if (strlen($prenom) > 30) {
            throw new \InvalidArgumentException('Le prénom doit contenir au maximum 30 caractères.');
        }

        // Vérifiez la regex
        if (!preg_match('/^[a-zA-Z][a-zA-Z\' -]{1,30}$/', $prenom)) {
            throw new \InvalidArgumentException('Le prénom est incorrect.');
        } */

        $this->prenom = $prenom;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        /* // Vérifiez la longueur du nom (30 caractères maximum)
        if (strlen($telephone) > 10) {
            throw new \InvalidArgumentException('Le numéro doit contenir au maximum 10 chiffres.');
        }

        // Vérifiez la regex
        if (!preg_match('/^[0-9]{10}$/', $telephone)) {
            throw new \InvalidArgumentException('Le numéro de téléphone est incorrect.');
        } */

        $this->telephone = $telephone;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        /* // Vérifiez la regex
        if (!preg_match('/^\d+\s/', $adresse)) {
            throw new \InvalidArgumentException("L'adresse est incorrecte.");
        } */

        $this->adresse = $adresse;
        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): static
    {
        /* // Vérifiez la longueur du nom (30 caractères maximum)
        if (strlen($cp) > 5) {
            throw new \InvalidArgumentException('Le code postal doit contenir 5 chiffres.');
        }

        // Vérifiez la regex
        if (!preg_match('/\\d{5}/', $cp)) {
            throw new \InvalidArgumentException('Le code postal est incorrect.');
        } */

        $this->cp = $cp;
        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        /* // Vérifiez la longueur du nom (30 caractères maximum)
        if (strlen($ville) > 40) {
            throw new \InvalidArgumentException('Le nom de ville doit contenir au maximum 40 caractères.');
        }

        // Vérifiez la regex
        if (!preg_match('/^[a-zA-Z][a-zA-Z\' -]{1,40}$/', $ville)) {
            throw new \InvalidArgumentException('Le nom de ville est incorrect.');
        } */

        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setUtilisateur($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUtilisateur() === $this) {
                $commande->setUtilisateur(null);
            }
        }

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
