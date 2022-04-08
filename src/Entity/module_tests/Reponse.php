<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse")
 * @ORM\Entity
 */
class Reponse
{
    /**
     * @var int
     *
     * @ORM\Column(name="idReponse", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reponses")
     * @ORM\JoinColumn(name="idUser", nullable=false)
     */
    private $iduser;

    /**
     *
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="reponses")
     * @ORM\JoinColumn(name="idTest", nullable=false)
     */
    private $idtest;

    /**
     *
     * @ORM\ManyToOne(targetEntity=Choix::class, inversedBy="reponses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idchoix;

    /**
     * @var bool
     *
     * @ORM\Column(name="correct", type="boolean", nullable=false)
     */
    private $correct;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIduser(): ?int
    {
        return $this->iduser;
    }

    public function setIduser(?User $iduser): self
    {
        $this->iduser = $iduser;

        return $this;
    }

    public function getIdtest(): ?Test
    {
        return $this->idtest;
    }

    public function setIdtest(?Test $idtest): self
    {
        $this->idtest = $idtest;

        return $this;
    }

    public function getIdchoix(): ?int
    {
        return $this->idchoix;
    }

    public function setIdchoix(?Choix $idchoix): self
    {
        $this->idchoix = $idchoix;

        return $this;
    }

    public function getCorrect(): ?bool
    {
        return $this->correct;
    }

    public function setCorrect(bool $correct): self
    {
        $this->correct = $correct;

        return $this;
    }


}
