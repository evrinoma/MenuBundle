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

namespace Evrinoma\MenuBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Evrinoma\MenuBundle\DependencyInjection\Compiler\MenuItemPass;
use Evrinoma\MenuBundle\DependencyInjection\EvrinomaMenuBundleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaMenuBundle extends Bundle
{
    public const MENU_BUNDLE = 'menu';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $ormCompilerClass = 'Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass';
        if (class_exists($ormCompilerClass)) {
            $container->addCompilerPass(
                DoctrineOrmMappingsPass::createAnnotationMappingDriver(
                    ['Evrinoma\MenuBundle\Entity'],
                    [sprintf('%s/Entity', $this->getPath())]
                )
            );
        }

        $container->addCompilerPass(new MenuItemPass());
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaMenuBundleExtension();
        }

        return $this->extension;
    }
}
