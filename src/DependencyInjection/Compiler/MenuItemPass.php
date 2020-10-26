<?php

namespace Evrinoma\MenuBundle\DependencyInjection\Compiler;

use Evrinoma\MenuBundle\Manager\MenuManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class MenuItemPass
 *
 * @package Evrinoma\MenuBundle\DependencyInjection
 */
class MenuItemPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(MenuManager::class)) {
            return;
        }

        $definition = $container->findDefinition(MenuManager::class);

        $taggedServices = $container->findTaggedServiceIds('evrinoma.menu');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addMenuItem', [new Reference($id)]);
        }
    }
}