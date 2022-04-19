<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="idQuestion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * 
     * @ORM\ManyToOne(targetEntity=Test::class, inversedBy="questions")
     * @ORM\JoinColumn(name="test", nullable=false, referencedColumnName="idTest")
     */
    private $test;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="integer", nullable=true, options={"default"="0"})
     */
    private $score;

    /**
     * @var string
     *
     * @ORM\Column(name="enonce", type="string", length=500, nullable=false)
     */
    private $enonce;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="dateModification", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datemodification = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $datecreation = 'CURRENT_TIMESTAMP';

    /**
     * @ORM\OneToMany(targetEntity=Choix::class, mappedBy="question", orphanRemoval=true)
     */
    private $choices;

    public function __construct()
    {
        $this->choices = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTest(): ?int
    {
        return $this->test;
    }

    public function setTest(?Test $test): self
    {
        $test->addQuestion($this);
        $this->test = $test;
        return $this;
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

    public function getEnonce(): ?string
    {
        return $this->enonce;
    }

    public function setEnonce(string $enonce): self
    {
        $this->enonce = $enonce;

        return $this;
    }

    public function getDatemodification(): ?\DateTimeInterface
    {
        return $this->datemodification;
    }

    public function setDatemodification(?\DateTimeInterface $datemodification): self
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    public function getDatecreation(): ?\DateTimeInterface
    {
        return $this->datecreation;
    }

    public function setDatecreation(\DateTimeInterface $datecreation): self
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * @return Collection<int, Choix>
     */
    public function getChoices(): Collection
    {
        return $this->choices;
    }

    public function addChoice(Choix $choice): self
    {
        if (!$this->choices->contains($choice)) {
            $this->choices[] = $choice;
            $choice->setQuestion($this);
        }

        return $this;
    }

    public function removeChoice(Choix $choice): self
    {
        if ($this->choices->removeElement($choice)) {
            // set the owning side to null (unless already changed)
            if ($choice->getQuestion() === $this) {
                $choice->setQuestion(null);
            }
        }

        return $this;
    }


}
