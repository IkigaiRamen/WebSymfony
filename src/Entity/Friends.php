<?php

namespace App\Entity;

use App\Repository\FriendsRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass=FriendsRepository::class)
 */
class Friends
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="friend")
     * @ORM\JoinColumn(nullable=false)
     */
    private $UserOne;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="friend2")
     * @ORM\JoinColumn(nullable=false)
     */
    private $UserTwo;

  /**
     * @var \DateTime $ created_at
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserOne(): ?User
    {
        return $this->UserOne;
    }

    public function setUserOne(?User $UserOne): self
    {
        $this->UserOne = $UserOne;

        return $this;
    }

    public function getUserTwo(): ?User
    {
        return $this->UserTwo;
    }

    public function setUserTwo(?User $UserTwo): self
    {
        $this->UserTwo = $UserTwo;

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

   
}
