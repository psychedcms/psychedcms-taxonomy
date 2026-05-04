<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * Per-locale translation of a Taxonomy. Mirrors the pattern used by content
 * entities (BandTranslation, ReleaseTranslation, etc.) — Gedmo personal
 * translations keyed on (locale, object_id, field).
 */
#[ORM\Entity]
#[ORM\Table(name: 'taxonomy_translations')]
#[ORM\UniqueConstraint(name: 'uniq_taxonomy_trans', columns: ['locale', 'object_id', 'field'])]
class TaxonomyTranslation extends AbstractPersonalTranslation
{
    #[ORM\ManyToOne(targetEntity: Taxonomy::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'object_id', nullable: false, onDelete: 'CASCADE')]
    protected $object;
}
