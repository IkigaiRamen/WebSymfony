<?php

namespace App\Entity;

use App\Repository\PostuleRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass=PostuleRepository::class)
 */
class Postule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

   

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="postule", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Offre::class, inversedBy="postules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $offre;

    /**
     * @var \DateTime $ created_at
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToOne(targetEntity=Entretien::class, mappedBy="Postule", cascade={"persist", "remove"})
     */
    private $entretien;




    public function getId(): ?int
    {
        return $this->id;
    }



    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;

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
    public function __toString() {
        return $this->getOffre();
      }

    public function getEntretien(): ?Entretien
    {
        return $this->entretien;
    }

    public function setEntretien(Entretien $entretien): self
    {
        // set the owning side of the relation if necessary
        if ($entretien->getPostule() !== $this) {
            $entretien->setPostule($this);
        }

        $this->entretien = $entretien;

        return $this;
    }

   
}
