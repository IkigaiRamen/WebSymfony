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
     * @ORM\JoinColumn(name="idUser", nullable=false, referencedColumnName="id")
     */
    private $iduser;

    /**
     *
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="reponses")
     * @ORM\JoinColumn(name="idTest", nullable=false, referencedColumnName="idTest")
     */
    private $idtest;

    /**
     *
     * @ORM\ManyToOne(targetEntity=Choix::class, inversedBy="reponses")
     * @ORM\JoinColumn(name="idChoix", nullable=false, referencedColumnName="idChoix")
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

    public function setIduser(?User $user): self
    {
        $user->addReponse($this);
        $this->iduser = $user;

        return $this;
    }

    public function getIdtest(): ?Test
    {
        return $this->idtest;
    }

    public function setIdtest(?Test $test): self
    {
        $test->addReponse($this);
        $this->idtest = $test;

        return $this;
    }

    public function getIdchoix(): ?int
    {
        return $this->idchoix;
    }

    public function setIdchoix(?Choix $choix): self
    {
        $choix->addReponse($this);
        $this->idchoix = $choix;

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
