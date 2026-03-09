<?php

declare(strict_types=1);

namespace PsychedCms\Taxonomy;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class PsychedCmsTaxonomyBundle extends AbstractBundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        if ($builder->hasExtension('doctrine')) {
            $builder->prependExtensionConfig('doctrine', [
                'orm' => [
                    'mappings' => [
                        'PsychedCmsTaxonomy' => [
                            'type' => 'attribute',
                            'is_bundle' => false,
                            'dir' => $this->getPath() . '/src/Entity',
                            'prefix' => 'PsychedCms\Taxonomy\Entity',
                            'alias' => 'PsychedCmsTaxonomy',
                        ],
                    ],
                ],
            ]);
        }
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');
    }
}
