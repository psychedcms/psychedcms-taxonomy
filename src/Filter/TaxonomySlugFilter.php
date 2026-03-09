<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;

final class TaxonomySlugFilter extends AbstractFilter
{
    protected function filterProperty(
        string $property,
        mixed $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        ?Operation $operation = null,
        array $context = [],
    ): void {
        if (!$this->isPropertyEnabled($property, $resourceClass) || !$this->isPropertyMapped($property, $resourceClass, true)) {
            return;
        }

        if ($value === null || $value === '') {
            return;
        }

        $slugs = array_map('trim', explode(',', (string) $value));
        $slugs = array_filter($slugs, static fn (string $s) => $s !== '');

        if ($slugs === []) {
            return;
        }

        $alias = $queryBuilder->getRootAliases()[0];
        $joinAlias = $queryNameGenerator->generateJoinAlias($property);
        $paramName = $queryNameGenerator->generateParameterName($property);

        $queryBuilder
            ->join(\sprintf('%s.%s', $alias, $property), $joinAlias)
            ->andWhere(\sprintf('%s.slug IN (:%s)', $joinAlias, $paramName))
            ->setParameter($paramName, $slugs);
    }

    /**
     * @return array<string, array{property: string, type: string, required: bool, description: string, openapi: array{description: string, name: string, type: string}}>
     */
    public function getDescription(string $resourceClass): array
    {
        $description = [];

        foreach ($this->getProperties() ?? [] as $property => $strategy) {
            $description[$property] = [
                'property' => $property,
                'type' => 'string',
                'required' => false,
                'description' => \sprintf('Filter by %s slug(s). Use commas to separate multiple values.', $property),
                'openapi' => [
                    'description' => \sprintf('Filter by %s slug(s), comma-separated', $property),
                    'name' => $property,
                    'type' => 'string',
                ],
            ];
        }

        return $description;
    }
}
