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

namespace Evrinoma\MenuBundle\DependencyInjection\Compiler;

use Evrinoma\MenuBundle\Registry\ObjectRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ObjectRegistryPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(ObjectRegistry::class)) {
            return;
        }

        $definition = $container->findDefinition(ObjectRegistry::class);

        $taggedServices = $container->findTaggedServiceIds('evrinoma.menu');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addObject', [new Reference($id)]);
        }
    }
}
