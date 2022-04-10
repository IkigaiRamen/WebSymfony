<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity
 */
class Evaluation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idEvaluation", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer", nullable=false)
     */
    private $score;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrQuestion", type="integer", nullable=false)
     */
    private $nbrquestion;

    /**
     * @var bool
     *
     * @ORM\Column(name="success", type="boolean", nullable=false)
     */
    private $success;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="evaluations")
     * @ORM\JoinColumn(name="idUser", nullable=false, referencedColumnName="id")
     */
    private $iduser;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="evaluations")
     * @ORM\JoinColumn(name="idTest", nullable=false,referencedColumnName="idTest")
     */
    private $idtest;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getNbrquestion(): ?int
    {
        return $this->nbrquestion;
    }

    public function setNbrquestion(int $nbrquestion): self
    {
        $this->nbrquestion = $nbrquestion;

        return $this;
    }

    public function getSuccess(): ?bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): self
    {
        $this->success = $success;

        return $this;
    }

    public function getIduser(): ?User
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


}
