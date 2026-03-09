<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Entity;

interface TaxonomyTermInterface
{
    /**
     * Returns the human-readable label for this term.
     * Used by the admin to display the term in lists and inputs.
     */
    public function getTaxonomyLabel(): string;
}
