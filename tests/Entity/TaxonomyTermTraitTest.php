<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Tests\Entity;

use PHPUnit\Framework\TestCase;
use PsychedCms\Taxonomy\Entity\Taxonomy;

final class TaxonomyTermTraitTest extends TestCase
{
    public function testParentIsNullByDefault(): void
    {
        $taxonomy = new Taxonomy();

        $this->assertNull($taxonomy->getParent());
    }

    public function testIsRootWhenNoParent(): void
    {
        $taxonomy = new Taxonomy();

        $this->assertTrue($taxonomy->isRoot());
    }

    public function testGetSetParent(): void
    {
        $parent = new Taxonomy();
        $child = new Taxonomy();

        $result = $child->setParent($parent);

        $this->assertSame($child, $result);
        $this->assertSame($parent, $child->getParent());
        $this->assertFalse($child->isRoot());
    }

    public function testChildrenEmptyByDefault(): void
    {
        $taxonomy = new Taxonomy();

        $this->assertCount(0, $taxonomy->getChildren());
    }

    public function testAddChild(): void
    {
        $parent = new Taxonomy();
        $child = new Taxonomy();

        $result = $parent->addChild($child);

        $this->assertSame($parent, $result);
        $this->assertCount(1, $parent->getChildren());
        $this->assertSame($parent, $child->getParent());
    }

    public function testAddChildDoesNotDuplicate(): void
    {
        $parent = new Taxonomy();
        $child = new Taxonomy();

        $parent->addChild($child);
        $parent->addChild($child);

        $this->assertCount(1, $parent->getChildren());
    }

    public function testRemoveChild(): void
    {
        $parent = new Taxonomy();
        $child = new Taxonomy();

        $parent->addChild($child);
        $parent->removeChild($child);

        $this->assertCount(0, $parent->getChildren());
        $this->assertNull($child->getParent());
    }

    public function testTaxonomyTermPositionDefaultsToZero(): void
    {
        $taxonomy = new Taxonomy();

        $this->assertSame(0, $taxonomy->getTaxonomyTermPosition());
    }

    public function testGetSetTaxonomyTermPosition(): void
    {
        $taxonomy = new Taxonomy();
        $result = $taxonomy->setTaxonomyTermPosition(3);

        $this->assertSame($taxonomy, $result);
        $this->assertSame(3, $taxonomy->getTaxonomyTermPosition());
    }
}
