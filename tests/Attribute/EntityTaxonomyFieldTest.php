<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Tests\Attribute;

use Attribute;
use PHPUnit\Framework\TestCase;
use PsychedCms\Core\Attribute\Field\FieldAttributeInterface;
use PsychedCms\Taxonomy\Attribute\EntityTaxonomyField;
use ReflectionClass;

final class EntityTaxonomyFieldTest extends TestCase
{
    public function testImplementsFieldAttributeInterface(): void
    {
        $attribute = new EntityTaxonomyField();

        $this->assertInstanceOf(FieldAttributeInterface::class, $attribute);
    }

    public function testGetFieldTypeReturnsEntityTaxonomy(): void
    {
        $attribute = new EntityTaxonomyField();

        $this->assertSame('entity_taxonomy', $attribute->getFieldType());
    }

    public function testToSchemaArrayReturnsCorrectType(): void
    {
        $attribute = new EntityTaxonomyField();
        $schema = $attribute->toSchemaArray();

        $this->assertSame('entity_taxonomy', $schema['type']);
    }

    public function testMultipleDefaultsToFalse(): void
    {
        $attribute = new EntityTaxonomyField();

        $this->assertFalse($attribute->multiple);
    }

    public function testMultipleOmittedFromSchemaWhenFalse(): void
    {
        $attribute = new EntityTaxonomyField();
        $schema = $attribute->toSchemaArray();

        $this->assertArrayNotHasKey('multiple', $schema);
    }

    public function testMultipleIncludedInSchemaWhenTrue(): void
    {
        $attribute = new EntityTaxonomyField(multiple: true);
        $schema = $attribute->toSchemaArray();

        $this->assertArrayHasKey('multiple', $schema);
        $this->assertTrue($schema['multiple']);
    }

    public function testAllowCreateDefaultsToFalse(): void
    {
        $attribute = new EntityTaxonomyField();

        $this->assertFalse($attribute->allowCreate);
    }

    public function testAllowCreateOmittedFromSchemaWhenFalse(): void
    {
        $attribute = new EntityTaxonomyField();
        $schema = $attribute->toSchemaArray();

        $this->assertArrayNotHasKey('allowCreate', $schema);
    }

    public function testAllowCreateIncludedInSchemaWhenTrue(): void
    {
        $attribute = new EntityTaxonomyField(allowCreate: true);
        $schema = $attribute->toSchemaArray();

        $this->assertArrayHasKey('allowCreate', $schema);
        $this->assertTrue($schema['allowCreate']);
    }

    public function testMinIncludedInSchemaWhenSet(): void
    {
        $attribute = new EntityTaxonomyField(min: 2);
        $schema = $attribute->toSchemaArray();

        $this->assertArrayHasKey('min', $schema);
        $this->assertSame(2, $schema['min']);
    }

    public function testMinOmittedFromSchemaWhenNull(): void
    {
        $attribute = new EntityTaxonomyField();
        $schema = $attribute->toSchemaArray();

        $this->assertArrayNotHasKey('min', $schema);
    }

    public function testMaxIncludedInSchemaWhenSet(): void
    {
        $attribute = new EntityTaxonomyField(max: 3);
        $schema = $attribute->toSchemaArray();

        $this->assertArrayHasKey('max', $schema);
        $this->assertSame(3, $schema['max']);
    }

    public function testMaxOmittedFromSchemaWhenNull(): void
    {
        $attribute = new EntityTaxonomyField();
        $schema = $attribute->toSchemaArray();

        $this->assertArrayNotHasKey('max', $schema);
    }

    public function testOrderIncludedInSchemaWhenSet(): void
    {
        $attribute = new EntityTaxonomyField(order: 'name');
        $schema = $attribute->toSchemaArray();

        $this->assertArrayHasKey('order', $schema);
        $this->assertSame('name', $schema['order']);
    }

    public function testOrderOmittedFromSchemaWhenNull(): void
    {
        $attribute = new EntityTaxonomyField();
        $schema = $attribute->toSchemaArray();

        $this->assertArrayNotHasKey('order', $schema);
    }

    public function testFilterIncludedInSchemaWhenSet(): void
    {
        $attribute = new EntityTaxonomyField(filter: 'active=true');
        $schema = $attribute->toSchemaArray();

        $this->assertArrayHasKey('filter', $schema);
        $this->assertSame('active=true', $schema['filter']);
    }

    public function testFilterOmittedFromSchemaWhenNull(): void
    {
        $attribute = new EntityTaxonomyField();
        $schema = $attribute->toSchemaArray();

        $this->assertArrayNotHasKey('filter', $schema);
    }

    public function testAllOptionsIncludedInSchema(): void
    {
        $attribute = new EntityTaxonomyField(
            multiple: true,
            allowCreate: true,
            min: 1,
            max: 5,
            order: 'name',
            filter: 'active=true',
            label: 'Categories',
            required: true,
        );
        $schema = $attribute->toSchemaArray();

        $this->assertSame('entity_taxonomy', $schema['type']);
        $this->assertTrue($schema['multiple']);
        $this->assertTrue($schema['allowCreate']);
        $this->assertSame(1, $schema['min']);
        $this->assertSame(5, $schema['max']);
        $this->assertSame('name', $schema['order']);
        $this->assertSame('active=true', $schema['filter']);
        $this->assertSame('Categories', $schema['label']);
        $this->assertTrue($schema['required']);
    }

    public function testAttributeTargetsPropertyOnly(): void
    {
        $reflection = new ReflectionClass(EntityTaxonomyField::class);
        $attributes = $reflection->getAttributes(Attribute::class);

        $this->assertCount(1, $attributes);

        $attributeInstance = $attributes[0]->newInstance();
        $this->assertSame(Attribute::TARGET_PROPERTY, $attributeInstance->flags);
    }
}
