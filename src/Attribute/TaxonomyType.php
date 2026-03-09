<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Attribute;

use Attribute;
use Symfony\Component\String\Inflector\EnglishInflector;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Attribute(Attribute::TARGET_CLASS)]
final class TaxonomyType
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $singularName = null,
        public readonly ?string $slug = null,
        public readonly ?string $singularSlug = null,
        public readonly bool $hierarchical = false,
        public readonly bool $allowCreate = false,
    ) {
    }

    /**
     * @param class-string $className Used to derive defaults from class name
     * @return array<string, mixed>
     */
    public function toSchemaArray(string $className): array
    {
        $singularName = $this->singularName ?? $this->camelCaseToWords($this->deriveShortName($className));
        $name = $this->name ?? $this->pluralize($singularName);
        $singularSlug = $this->singularSlug ?? $this->slugify($singularName);
        $slug = $this->slug ?? $this->slugify($name);

        return [
            'name' => $name,
            'singularName' => $singularName,
            'slug' => $slug,
            'singularSlug' => $singularSlug,
            'hierarchical' => $this->hierarchical,
            'allowCreate' => $this->allowCreate,
        ];
    }

    private function deriveShortName(string $className): string
    {
        $parts = explode('\\', $className);

        return end($parts);
    }

    private function pluralize(string $singular): string
    {
        $inflector = new EnglishInflector();
        $plurals = $inflector->pluralize($singular);

        return end($plurals);
    }

    private function slugify(string $text): string
    {
        $wordsText = $this->camelCaseToWords($text);
        $slugger = new AsciiSlugger();

        return $slugger->slug($wordsText)->lower()->toString();
    }

    private function camelCaseToWords(string $text): string
    {
        return preg_replace('/(?<!^)([A-Z])/', ' $1', $text) ?? $text;
    }
}
