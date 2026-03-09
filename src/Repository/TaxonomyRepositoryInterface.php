<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Repository;

use PsychedCms\Taxonomy\Entity\Taxonomy;

interface TaxonomyRepositoryInterface
{
    /**
     * @return iterable<Taxonomy>
     */
    public function findByType(string $type): iterable;

    /**
     * @return iterable<Taxonomy>
     */
    public function findRootsByType(string $type): iterable;

    public function findByTypeAndSlug(string $type, string $slug): ?Taxonomy;

    /**
     * @param string[] $slugs
     * @return iterable<Taxonomy>
     */
    public function findByTypeAndSlugs(string $type, array $slugs): iterable;

    public function save(Taxonomy $taxonomy): void;

    public function delete(Taxonomy $taxonomy): void;
}
