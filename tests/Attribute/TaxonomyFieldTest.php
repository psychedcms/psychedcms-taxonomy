<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Tests\Attribute;

use Attribute;
use PHPUnit\Framework\TestCase;
use PsychedCms\Core\Attribute\Field\FieldAttributeInterface;
use PsychedCms\Taxonomy\Attribute\TaxonomyField;
use ReflectionClass;

final class TaxonomyFieldTest extends TestCase
{
    public function testImplementsFieldAttributeInterface(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags');

        $this->assertInstanceOf(FieldAttributeInterface::class, $attribute);
    }

    public function testGetFieldTypeReturnsTaxonomy(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags');

        $this->assertSame('taxonomy', $attribute->getFieldType());
    }

    public function testToSchemaArrayReturnsCorrectType(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags');
        $schema = $attribute->toSchemaArray();

        $this->assertSame('taxonomy', $schema['type']);
    }

    public function testTaxonomyAlwaysIncludedInSchema(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'categories');
        $schema = $attribute->toSchemaArray();

        $this->assertArrayHasKey('taxonomy', $schema);
        $this->assertSame('categories', $schema['taxonomy']);
    }

    public function testMultipleDefaultsToFalse(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags');

        $this->assertFalse($attribute->multiple);
    }

    public function testMultipleOmittedFromSchemaWhenFalse(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags');
        $schema = $attribute->toSchemaArray();

        $this->assertArrayNotHasKey('multiple', $schema);
    }

    public function testMultipleIncludedInSchemaWhenTrue(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags', multiple: true);
        $schema = $attribute->toSchemaArray();

        $this->assertArrayHasKey('multiple', $schema);
        $this->assertTrue($schema['multiple']);
    }

    public function testAllowCreateDefaultsToFalse(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags');

        $this->assertFalse($attribute->allowCreate);
    }

    public function testAllowCreateOmittedFromSchemaWhenFalse(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags');
        $schema = $attribute->toSchemaArray();

        $this->assertArrayNotHasKey('allowCreate', $schema);
    }

    public function testAllowCreateIncludedInSchemaWhenTrue(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags', allowCreate: true);
        $schema = $attribute->toSchemaArray();

        $this->assertArrayHasKey('allowCreate', $schema);
        $this->assertTrue($schema['allowCreate']);
    }

    public function testMinIncludedInSchemaWhenSet(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags', min: 1);
        $schema = $attribute->toSchemaArray();

        $this->assertArrayHasKey('min', $schema);
        $this->assertSame(1, $schema['min']);
    }

    public function testMinOmittedFromSchemaWhenNull(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags');
        $schema = $attribute->toSchemaArray();

        $this->assertArrayNotHasKey('min', $schema);
    }

    public function testMaxIncludedInSchemaWhenSet(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags', max: 5);
        $schema = $attribute->toSchemaArray();

        $this->assertArrayHasKey('max', $schema);
        $this->assertSame(5, $schema['max']);
    }

    public function testMaxOmittedFromSchemaWhenNull(): void
    {
        $attribute = new TaxonomyField(taxonomy: 'tags');
        $schema = $attribute->toSchemaArray();

        $this->assertArrayNotHasKey('max', $schema);
    }

    public function testAllOptionsIncludedInSchema(): void
    {
        $attribute = new TaxonomyField(
            taxonomy: 'tags',
            multiple: true,
            allowCreate: true,
            min: 1,
            max: 10,
            label: 'Tags',
            required: true,
        );
        $schema = $attribute->toSchemaArray();

        $this->assertSame('taxonomy', $schema['type']);
        $this->assertSame('tags', $schema['taxonomy']);
        $this->assertTrue($schema['multiple']);
        $this->assertTrue($schema['allowCreate']);
        $this->assertSame(1, $schema['min']);
        $this->assertSame(10, $schema['max']);
        $this->assertSame('Tags', $schema['label']);
        $this->assertTrue($schema['required']);
    }

    public function testAttributeTargetsPropertyOnly(): void
    {
        $reflection = new ReflectionClass(TaxonomyField::class);
        $attributes = $reflection->getAttributes(Attribute::class);

        $this->assertCount(1, $attributes);

        $attributeInstance = $attributes[0]->newInstance();
        $this->assertSame(Attribute::TARGET_PROPERTY, $attributeInstance->flags);
    }
}
