<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait TaxonomyTermTrait
{
    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?self $parent = null;

    /**
     * @var Collection<int, static>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parent')]
    #[ORM\OrderBy(['taxonomyTermPosition' => 'ASC'])]
    private Collection $children;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 0])]
    private int $taxonomyTermPosition = 0;

    public function getParent(): ?static
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection<int, static>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->children->removeElement($child)) {
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function isRoot(): bool
    {
        return $this->parent === null;
    }

    public function getTaxonomyTermPosition(): int
    {
        return $this->taxonomyTermPosition;
    }

    public function setTaxonomyTermPosition(int $taxonomyTermPosition): static
    {
        $this->taxonomyTermPosition = $taxonomyTermPosition;

        return $this;
    }

    private function initializeTaxonomyTermCollections(): void
    {
        $this->children = new ArrayCollection();
    }
}
