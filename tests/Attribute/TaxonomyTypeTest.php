<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Tests\Attribute;

use PHPUnit\Framework\TestCase;
use PsychedCms\Taxonomy\Attribute\TaxonomyType;
use ReflectionClass;

final class TaxonomyTypeTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $attr = new TaxonomyType();

        $this->assertNull($attr->name);
        $this->assertNull($attr->singularName);
        $this->assertNull($attr->slug);
        $this->assertNull($attr->singularSlug);
        $this->assertFalse($attr->hierarchical);
        $this->assertFalse($attr->allowCreate);
    }

    public function testCustomValues(): void
    {
        $attr = new TaxonomyType(
            name: 'Music Genres',
            singularName: 'Genre',
            slug: 'music-genres',
            singularSlug: 'genre',
            hierarchical: true,
            allowCreate: true,
        );

        $this->assertSame('Music Genres', $attr->name);
        $this->assertSame('Genre', $attr->singularName);
        $this->assertSame('music-genres', $attr->slug);
        $this->assertSame('genre', $attr->singularSlug);
        $this->assertTrue($attr->hierarchical);
        $this->assertTrue($attr->allowCreate);
    }

    public function testToSchemaArrayDerivesFromClassName(): void
    {
        $attr = new TaxonomyType(hierarchical: true);
        $schema = $attr->toSchemaArray('App\\Entity\\Genre');

        $this->assertSame('Genres', $schema['name']);
        $this->assertSame('Genre', $schema['singularName']);
        $this->assertSame('genres', $schema['slug']);
        $this->assertSame('genre', $schema['singularSlug']);
        $this->assertTrue($schema['hierarchical']);
        $this->assertFalse($schema['allowCreate']);
    }

    public function testToSchemaArrayUsesExplicitValues(): void
    {
        $attr = new TaxonomyType(name: 'Music Genres', slug: 'music-genres');
        $schema = $attr->toSchemaArray('App\\Entity\\Genre');

        $this->assertSame('Music Genres', $schema['name']);
        $this->assertSame('music-genres', $schema['slug']);
        // singularName still derived from class name
        $this->assertSame('Genre', $schema['singularName']);
    }

    public function testToSchemaArrayDerivesCamelCase(): void
    {
        $attr = new TaxonomyType();
        $schema = $attr->toSchemaArray('App\\Entity\\ContentCategory');

        $this->assertSame('Content Categories', $schema['name']);
        $this->assertSame('Content Category', $schema['singularName']);
        $this->assertSame('content-categories', $schema['slug']);
        $this->assertSame('content-category', $schema['singularSlug']);
    }

    public function testAttributeTargetsClassOnly(): void
    {
        $ref = new ReflectionClass(TaxonomyType::class);
        $attrs = $ref->getAttributes(\Attribute::class);

        $this->assertCount(1, $attrs);

        $instance = $attrs[0]->newInstance();
        $this->assertSame(\Attribute::TARGET_CLASS, $instance->flags);
    }
}
