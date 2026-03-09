<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use PsychedCms\Taxonomy\Repository\TaxonomyRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TaxonomyRepository::class)]
#[ORM\Table(name: 'taxonomies')]
#[ORM\UniqueConstraint(name: 'uniq_taxonomies_type_slug', columns: ['type', 'slug'])]
#[ORM\Index(columns: ['type'], name: 'idx_taxonomies_type')]
#[ORM\Index(columns: ['parent_id'], name: 'idx_taxonomies_parent')]
#[ApiResource(mercure: true)]
#[ApiFilter(SearchFilter::class, properties: ['type' => 'exact', 'name' => 'partial', 'slug' => 'exact', 'parent' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['taxonomyTermPosition', 'name'])]
class Taxonomy implements TaxonomyTermInterface
{
    use TaxonomyTermTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 64)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[Assert\Regex(pattern: '/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Gedmo\Timestampable(on: 'update')]
    private ?DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->initializeTaxonomyTermCollections();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTaxonomyLabel(): string
    {
        return $this->name ?? '';
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
