<?php

namespace App\Entity;
use Symfony\Component\HttpFoundation\File\File;
use App\Repository\MessagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=MessagesRepository::class)
 * * @Vich\Uploadable
 */
class Messages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_read = 0;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="received")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipient;

    /**
     * @ORM\OneToMany(targetEntity=Discussion::class, mappedBy="Messages")
     */
    private $discussion;

    /**
     * @ORM\ManyToMany(targetEntity=Discussion::class, inversedBy="Messages")
     */
    private $Discussion;


    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $contract;

    /**
     * @Vich\UploadableField(mapping="messages_contracts", fileNameProperty="contract")
     * @var File
     */
    private $contractFile;




    public function getContractFile()
                                                                {
    return $this->contractFile;
                                                                }

    public function setContractFile(?File $contractFile): self
    {
        $this->contractFile = $contractFile;
        
        return $this;

    }

    public function getContract(): ?string
    {
        return $this->contract;
    }

    public function setContract(string $Contract): self
    {
        $this->Contract = $Contract;

        return $this;
    }
 

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->discussion = new ArrayCollection();
        $this->Discussion = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

    public function getIsRead(): ?bool
    {
        return $this->is_read;
    }

    public function setIsRead(bool $is_read): self
    {
        $this->is_read = $is_read;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?User
    {
        return $this->recipient;
    }

    public function setRecipient(?User $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * @return Collection|Discussion[]
     */
    public function getDiscussion(): Collection
    {
        return $this->discussion;
    }

    public function addDiscussion(Discussion $discussion): self
    {
        if (!$this->discussion->contains($discussion)) {
            $this->discussion[] = $discussion;
            $discussion->setMessages($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): self
    {
        if ($this->discussion->removeElement($discussion)) {
            // set the owning side to null (unless already changed)
            if ($discussion->getMessages() === $this) {
                $discussion->setMessages(null);
            }
        }

        return $this;
    }
    public function __toString() {
        return $this->message;
    }
}
