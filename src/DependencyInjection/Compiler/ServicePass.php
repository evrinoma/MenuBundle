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

use Evrinoma\MenuBundle\EvrinomaMenuBundle;
use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServicePass extends AbstractRecursivePass
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $servicePreValidator = $container->hasParameter('evrinoma.'.EvrinomaMenuBundle::BUNDLE.'.services.pre.validator');
        if ($servicePreValidator) {
            $servicePreValidator = $container->getParameter('evrinoma.'.EvrinomaMenuBundle::BUNDLE.'.services.pre.validator');
            $preValidator = $container->getDefinition($servicePreValidator);
            $apiController = $container->getDefinition('evrinoma.'.EvrinomaMenuBundle::BUNDLE.'.api.controller');
            $apiController->setArgument(5, $preValidator);
        }
    }
}
