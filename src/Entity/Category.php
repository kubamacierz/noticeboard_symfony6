<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $categoryName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): static
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    // Relations

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Notice::class)]
    private ?Collection $notices;

    public function getNotice(): Notice
    {
        return $this->notice;
    }

    public function setNotice(Notice $notice = null): ?Category
    {
        $this->notice = $notice;

        return $this;
    }

    public function __construct()
    {
        $this->notices = new ArrayCollection();
    }

    public function addNotice(Notice $notice): Category
    {
        $this->notices[] = $notice;

        return $this;
    }

    /**
     * Remove notice
     *
     * @param Notice $notice
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeNotice(Notice $notice): bool
    {
        return $this->notices->removeElement($notice);
    }

    public function getNotices(): Collection
    {
        return $this->notices;
    }

}
