<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Tests\Entity;

use PHPUnit\Framework\TestCase;
use PsychedCms\Taxonomy\Entity\Taxonomy;
use PsychedCms\Taxonomy\Entity\TaxonomyTermInterface;

final class TaxonomyTest extends TestCase
{
    public function testImplementsTaxonomyTermInterface(): void
    {
        $taxonomy = new Taxonomy();

        $this->assertInstanceOf(TaxonomyTermInterface::class, $taxonomy);
    }

    public function testIdIsNullByDefault(): void
    {
        $taxonomy = new Taxonomy();

        $this->assertNull($taxonomy->getId());
    }

    public function testGetSetType(): void
    {
        $taxonomy = new Taxonomy();
        $result = $taxonomy->setType('tags');

        $this->assertSame($taxonomy, $result);
        $this->assertSame('tags', $taxonomy->getType());
    }

    public function testGetSetSlug(): void
    {
        $taxonomy = new Taxonomy();
        $result = $taxonomy->setSlug('my-tag');

        $this->assertSame($taxonomy, $result);
        $this->assertSame('my-tag', $taxonomy->getSlug());
    }

    public function testGetSetName(): void
    {
        $taxonomy = new Taxonomy();
        $result = $taxonomy->setName('My Tag');

        $this->assertSame($taxonomy, $result);
        $this->assertSame('My Tag', $taxonomy->getName());
    }

    public function testGetTaxonomyLabelReturnsName(): void
    {
        $taxonomy = new Taxonomy();
        $taxonomy->setName('Psych Rock');

        $this->assertSame('Psych Rock', $taxonomy->getTaxonomyLabel());
    }

    public function testGetTaxonomyLabelReturnsEmptyStringWhenNoName(): void
    {
        $taxonomy = new Taxonomy();

        $this->assertSame('', $taxonomy->getTaxonomyLabel());
    }

    public function testTaxonomyTermPositionDefaultsToZero(): void
    {
        $taxonomy = new Taxonomy();

        $this->assertSame(0, $taxonomy->getTaxonomyTermPosition());
    }

    public function testGetSetTaxonomyTermPosition(): void
    {
        $taxonomy = new Taxonomy();
        $result = $taxonomy->setTaxonomyTermPosition(5);

        $this->assertSame($taxonomy, $result);
        $this->assertSame(5, $taxonomy->getTaxonomyTermPosition());
    }

    public function testTimestampsAreNullByDefault(): void
    {
        $taxonomy = new Taxonomy();

        $this->assertNull($taxonomy->getCreatedAt());
        $this->assertNull($taxonomy->getUpdatedAt());
    }
}
