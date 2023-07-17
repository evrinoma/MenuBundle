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
        $treeBuilder = new TreeBuilder(EvrinomaMenuBundle::BUNDLE);
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
            ->scalarNode('constraints')->defaultTrue()->info('This option is used to enable/disable basic menu constraints')->end()
            ->scalarNode('dto')->cannotBeEmpty()->defaultValue(EvrinomaMenuExtension::DTO_BASE_MENU)->info('This option is used to dto class override')->end()
            ->scalarNode('preserve_dto')->cannotBeEmpty()->defaultValue(EvrinomaMenuExtension::DTO_PRESERVE_BASE_MENU)->info('This option is used to preserve_dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used to command menu decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used to query menu decoration')->end()
            ->end()->end()
            ->arrayNode('serializer')->addDefaultsIfNotSet()->children()
            ->scalarNode('enabled')->defaultTrue()->info('This option is used to enable/disable basic video_content serializers')->end()
            ->scalarNode('path')->cannotBeEmpty()->defaultValue(getcwd())->end()
            ->end()->end()
            ->arrayNode('services')->addDefaultsIfNotSet()->children()
            ->scalarNode('pre_validator')->defaultNull()->info('This option is used to pre_validator overriding')->end()
            ->scalarNode('create_bridge')->defaultNull()->info('This option is used to create_bridge overriding')->end()
            ->scalarNode('handler')->cannotBeEmpty()->defaultValue(EvrinomaMenuExtension::HANDLER)->info('This option is used to handler override')->end()
            ->end()->end()
            ->arrayNode('registry')->addDefaultsIfNotSet()->children()
            ->booleanNode('PredefinedMenu')->defaultTrue()->info('This option is used to enable logout menu item')->end()
            ->end()->end()
            ->end();

        return $treeBuilder;
    }
}
