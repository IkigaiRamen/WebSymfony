<?php

namespace App\Entity;

use App\Repository\DiscussionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiscussionRepository::class)
 */
class Discussion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="discussions")
     */
    private $User;

    /**
     * @ORM\ManyToMany(targetEntity=Messages::class, mappedBy="Discussion")
     */
    private $Messages;

    public function __construct()
    {
        $this->User = new ArrayCollection();
        $this->Messages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->User;
    }

    public function addUser(User $user): self
    {
        if (!$this->User->contains($user)) {
            $this->User[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->User->removeElement($user);

        return $this;
    }

    /**
     * @return Collection|Messages[]
     */
    public function getMessages(): Collection
    {
        return $this->Messages;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->Messages->contains($message)) {
            $this->Messages[] = $message;
            $message->addDiscussion($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->Messages->removeElement($message)) {
            $message->removeDiscussion($this);
        }

        return $this;
    }
}
