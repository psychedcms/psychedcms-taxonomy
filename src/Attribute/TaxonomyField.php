<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Attribute;

use Attribute;
use PsychedCms\Core\Attribute\Field\FieldAttribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class TaxonomyField extends FieldAttribute
{
    public function __construct(
        public readonly string $taxonomy,
        public readonly bool $multiple = false,
        public readonly bool $allowCreate = false,
        public readonly ?int $min = null,
        public readonly ?int $max = null,
        ?string $label = null,
        ?string $group = null,
        ?string $placeholder = null,
        ?string $info = null,
        ?string $prefix = null,
        ?string $postfix = null,
        bool $separator = false,
        ?string $class = null,
        mixed $default = null,
        bool $required = false,
        bool $readonly = false,
        ?string $pattern = null,
        bool $index = false,
        bool $searchable = false,
        bool $translatable = false,
        bool $sanitise = true,
        ?bool $allowHtml = null,
        ?bool $listColumn = null,
        ?int $listColumnOrder = null,
        ?string $listDisplayPattern = null,
        bool $listSortable = false,
        bool $listFilterable = false,
        ?string $listFilterType = null,
    ) {
        parent::__construct(
            label: $label,
            group: $group,
            placeholder: $placeholder,
            info: $info,
            prefix: $prefix,
            postfix: $postfix,
            separator: $separator,
            class: $class,
            default: $default,
            required: $required,
            readonly: $readonly,
            pattern: $pattern,
            index: $index,
            searchable: $searchable,
            translatable: $translatable,
            sanitise: $sanitise,
            allowHtml: $allowHtml,
            listColumn: $listColumn,
            listColumnOrder: $listColumnOrder,
            listDisplayPattern: $listDisplayPattern,
            listSortable: $listSortable,
            listFilterable: $listFilterable,
            listFilterType: $listFilterType,
        );
    }

    public function getFieldType(): string
    {
        return 'taxonomy';
    }

    /**
     * @return array<string, mixed>
     */
    public function toSchemaArray(): array
    {
        $schema = parent::toSchemaArray();

        $schema['taxonomy'] = $this->taxonomy;

        if ($this->multiple) {
            $schema['multiple'] = $this->multiple;
        }

        if ($this->allowCreate) {
            $schema['allowCreate'] = $this->allowCreate;
        }

        if ($this->min !== null) {
            $schema['min'] = $this->min;
        }

        if ($this->max !== null) {
            $schema['max'] = $this->max;
        }

        return $schema;
    }
}
