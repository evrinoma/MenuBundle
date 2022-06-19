<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\MenuBundle\DependencyInjection;

use Evrinoma\MenuBundle\EvrinomaMenuBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(EvrinomaMenuBundle::MENU_BUNDLE);
        $rootNode = $treeBuilder->getRootNode();
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('factory')->cannotBeEmpty()->defaultValue(EvrinomaMenuExtension::ENTITY_FACTORY_MENU)->end()
            ->scalarNode('entity')->cannotBeEmpty()->defaultValue(EvrinomaMenuExtension::ENTITY_BASE_MENU)->end()
            ->scalarNode('constraints')->defaultTrue()->info('This option is used for enable/disable basic menu constraints')->end()
            ->scalarNode('dto')->cannotBeEmpty()->defaultValue(EvrinomaMenuExtension::DTO_BASE_MENU)->info('This option is used for dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used for command menu decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used for query menu decoration')->end()
            ->end()->end()
            ->arrayNode('services')->addDefaultsIfNotSet()->children()
            ->scalarNode('pre_validator')->defaultNull()->info('This option is used for pre_validator overriding')->end()
            ->end()->end()
            ->end();

        return $treeBuilder;
    }
}
