<?php

namespace App\Entity;

use App\Repository\NoticeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: NoticeRepository::class)]
class Notice
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255, nullable: false)]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private \DateTimeInterface $expiration;

    private ArrayCollection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getExpiration(): \DateTimeInterface
    {
        return $this->expiration;
    }

    public function setExpiration(\DateTimeInterface $expiration): static
    {
        $this->expiration = $expiration;

        return $this;
    }

    public function getCategories(): ?ArrayCollection
    {
        return $this->categories;
    }

    // Relations

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'notices')]
    #[ORM\JoinColumn(name: 'category_id', referencedColumnName: 'id')]
    private ?Category $category;

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category = null): Notice
    {
        $this->category = $category;

        return $this;
    }

    public function addCategory(Category $category): Notice
    {
        $this->categories[] = $this->category;

        return $this;
    }

    /**
     * Remove category.
     *
     * @param Category $category
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCategory(Category $category): bool
    {
        return $this->categories->removeElement($this->category);
    }

    // Relations

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'notices')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getUserId(): ?Uuid
    {
        return $this->getUser()->getId();
    }

    public function setUser(?User $user): Notice
    {
        $this->user = $user;
        return $this;
    }


}
