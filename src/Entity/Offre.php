<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")     
     * @Groups("offre")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="offres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("offre")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("offre")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autres;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("offre")
     */
    private $responsibilities;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("offre")
     */
    private $eduexp;

    /**
     * @ORM\Column(type="date")
     */
    private $expire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("offre")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salairemin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salairemax;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("offre")
     */
    private $exp;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("offre")
     */
    private $qualification;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sex;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("offre")
     */
    private $city;


    /**
     * @var \DateTime $ created_at
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Postule::class, mappedBy="offre", orphanRemoval=true)
     */
    private $postules;

    public function __construct()
    {
        $this->postules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAutres(): ?string
    {
        return $this->autres;
    }

    public function setAutres(?string $autres): self
    {
        $this->autres = $autres;

        return $this;
    }

    public function getResponsibilities(): ?string
    {
        return $this->responsibilities;
    }

    public function setResponsibilities(string $responsibilities): self
    {
        $this->responsibilities = $responsibilities;

        return $this;
    }

    public function getEduexp(): ?string
    {
        return $this->eduexp;
    }

    public function setEduexp(string $eduexp): self
    {
        $this->eduexp = $eduexp;

        return $this;
    }

    public function getExpire(): ?\DateTimeInterface
    {
        return $this->expire;
    }

    public function setExpire(\DateTimeInterface $expire): self
    {
        $this->expire = $expire;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSalairemin(): ?string
    {
        return $this->salairemin;
    }

    public function setSalairemin(string $salairemin): self
    {
        $this->salairemin = $salairemin;

        return $this;
    }

    public function getSalairemax(): ?string
    {
        return $this->salairemax;
    }

    public function setSalairemax(string $salairemax): self
    {
        $this->salairemax = $salairemax;

        return $this;
    }

    public function getExp(): ?string
    {
        return $this->exp;
    }

    public function setExp(string $exp): self
    {
        $this->exp = $exp;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(string $qualification): self
    {
        $this->qualification = $qualification;

        return $this;
    }

    public function getSex(): ?string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Postule>
     */
    public function getPostules(): Collection
    {
        return $this->postules;
    }

    public function addPostule(Postule $postule): self
    {
        if (!$this->postules->contains($postule)) {
            $this->postules[] = $postule;
            $postule->setOffre($this);
        }

        return $this;
    }

    public function removePostule(Postule $postule): self
    {
        if ($this->postules->removeElement($postule)) {
            // set the owning side to null (unless already changed)
            if ($postule->getOffre() === $this) {
                $postule->setOffre(null);
            }
        }

        return $this;
    }
}
