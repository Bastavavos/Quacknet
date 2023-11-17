<?php

namespace App\Entity;

use App\Repository\QuackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuackRepository::class)]
class Quack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, )]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'relation')]
    private ?self $comment = null;

    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: self::class)]
    private Collection $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getComment(): ?self
    {
        return $this->comment;
    }

    public function setComment(?self $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(self $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setComment($this);
        }

        return $this;
    }

    public function removeRelation(self $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getComment() === $this) {
                $relation->setComment(null);
            }
        }

        return $this;
    }

    public function setParent(Quack $quack)
    {

    }
}
