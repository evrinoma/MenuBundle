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

use Evrinoma\MenuBundle\Dto\MenuApiDto;
use Evrinoma\MenuBundle\Dto\Preserve\MenuApiDto as PreserveMenuApiDto;
use Evrinoma\MenuBundle\Entity\Menu\BaseMenu;
use Evrinoma\MenuBundle\EvrinomaMenuBundle;
use Evrinoma\MenuBundle\Factory\Menu\Factory as MenuFactory;
use Evrinoma\MenuBundle\Mediator\QueryMediatorInterface;
use Evrinoma\MenuBundle\Menu\PredefinedMenu;
use Evrinoma\MenuBundle\Repository\Menu\MenuCommandRepositoryInterface;
use Evrinoma\MenuBundle\Repository\Menu\MenuQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Adaptor\AdaptorRegistry;
use Evrinoma\UtilsBundle\DependencyInjection\HelperTrait;
use Evrinoma\UtilsBundle\Handler\BaseHandler;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class EvrinomaMenuExtension extends Extension
{
    use HelperTrait;

    public const ENTITY = 'Evrinoma\MenuBundle\Entity';
    public const MODEL = 'Evrinoma\MenuBundle\Model';
    public const ENTITY_FACTORY_MENU = MenuFactory::class;
    public const ENTITY_BASE_MENU = BaseMenu::class;
    public const DTO_BASE_MENU = MenuApiDto::class;
    public const DTO_PRESERVE_BASE_MENU = PreserveMenuApiDto::class;
    public const HANDLER = BaseHandler::class;

    /**
     * @var array
     */
    private static array $doctrineDrivers = [
        'orm' => [
            'registry' => 'doctrine',
            'tag' => 'doctrine.event_subscriber',
        ],
    ];

    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ('prod' !== $container->getParameter('kernel.environment')) {
            $loader->load('fixtures.yml');
        }

        if ('test' === $container->getParameter('kernel.environment')) {
            $loader->load('tests.yml');
        }

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        if (self::ENTITY_FACTORY_MENU !== $config['factory']) {
            $this->wireFactory($container, $config['factory'], $config['entity']);
        } else {
            $definitionFactory = $container->getDefinition('evrinoma.'.$this->getAlias().'.factory');
            $definitionFactory->setArgument(0, $config['entity']);
        }

        $registry = null;

        if (isset(self::$doctrineDrivers[$config['db_driver']]) && 'orm' === $config['db_driver']) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.'.$this->getAlias().'.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));
            $registry = new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry');
            $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);
            $objectManager = $container->getDefinition('evrinoma.'.$this->getAlias().'.object_manager');
            $objectManager->setFactory([$registry, 'getManager']);
        }

        if (isset(self::$doctrineDrivers[$config['db_driver']]) && 'api' === $config['db_driver']) {
            // @ToDo
        }

        if (null !== $registry) {
            $this->wireAdaptorRegistry($container, $registry);
        }

        $this->wireMediator($container, QueryMediatorInterface::class, $config['db_driver']);

        $this->remapParametersNamespaces(
            $container,
            $config,
            [
                '' => [
                    'db_driver' => 'evrinoma.'.$this->getAlias().'.storage',
                    'entity' => 'evrinoma.'.$this->getAlias().'.entity',
                ],
            ]
        );

        if ($registry && isset(self::$doctrineDrivers[$config['db_driver']])) {
            $this->wireRepository($container, $registry, QueryMediatorInterface::class, $config['entity'], $config['db_driver']);
        }

        $this->wireController($container, $config['dto']);

        $this->wireValidator($container, $config['entity']);

//        if ($config['constraints']) {
//            $loader->load('validation.yml');
//        }
//
//        $this->wireConstraintTag($container);

        if ($config['serializer']['enabled']) {
            $loader->load('serializers.yml');
            $this->wireSerializer($container, $config['serializer']['path']);
        }

        $this->wireForm($container, $config['dto'], 'menu', 'tag');

        $this->wireBridge($container, $config['preserve_dto']);

        if ($config['decorates']) {
            $remap = [];
            foreach ($config['decorates'] as $key => $service) {
                if (null !== $service) {
                    switch ($key) {
                        case 'command':
                            $remap['command'] = 'evrinoma.'.$this->getAlias().'.decorates.command';
                            break;
                        case 'query':
                            $remap['query'] = 'evrinoma.'.$this->getAlias().'.decorates.query';
                            break;
                    }
                }
            }

            $this->remapParametersNamespaces(
                $container,
                $config['decorates'],
                ['' => $remap]
            );
        }

        if ($config['services']) {
            $remap = [];
            foreach ($config['services'] as $key => $service) {
                if (null !== $service) {
                    switch ($key) {
                        case 'pre_validator':
                            $remap['pre_validator'] = 'evrinoma.'.$this->getAlias().'.services.pre.validator';
                            break;
                        case 'handler':
                            $remap['handler'] = 'evrinoma.'.$this->getAlias().'.services.handler';
                            break;
                    }
                }
            }

            $this->remapParametersNamespaces(
                $container,
                $config['services'],
                ['' => $remap]
            );
        }

        if ($config['registry']) {
            foreach ($config['registry'] as $key => $item) {
                switch (true) {
                    case str_contains(PredefinedMenu::class, $key)   :
                        if ($item) {
                            $predefinedMenu = $container->getDefinition(PredefinedMenu::class);
                            $predefinedMenu->setArgument(0, $config['preserve_dto']);
                        } else {
                            $container->removeDefinition(PredefinedMenu::class);
                        }
                        break;
                    default:
                }
            }
        }
    }

    private function wireMediator(ContainerBuilder $container, string $class, string $driver): void
    {
        $definitionQueryMediator = $container->getDefinition('evrinoma.'.$this->getAlias().'.query.'.$driver.'.mediator');
        $container->addDefinitions([$class => $definitionQueryMediator]);
    }

    private function wireAdaptorRegistry(ContainerBuilder $container, Reference $registry): void
    {
        $definitionAdaptor = new Definition(AdaptorRegistry::class);
        $definitionAdaptor->addArgument($registry);
        $container->addDefinitions(['evrinoma.'.$this->getAlias().'.adaptor' => $definitionAdaptor]);
    }

    private function wireBridge(ContainerBuilder $container, string $class): void
    {
        $definitionBridgeCreate = $container->getDefinition('evrinoma.'.$this->getAlias().'.bridge.create');
        $definitionBridgeCreate->setArgument(1, $class);
    }

    private function wireSerializer(ContainerBuilder $container, string $path): void
    {
        foreach ($container->findTaggedServiceIds('evrinoma.serializer') as $key => $item) {
            if (strcmp('evrinoma.'.$this->getAlias(), $key)) {
                $definition = $container->getDefinition($key);
                $definition->setArgument(0, $path);
            }
        }
    }

//    private function wireConstraintTag(ContainerBuilder $container): void
//    {
//        foreach ($container->getDefinitions() as $key => $definition) {
//            switch (true) {
//                case str_contains($key, UserPass::MENU_CONSTRAINT)   :
//                    $definition->addTag(UserPass::MENU_CONSTRAINT);
//                    break;
//                default:
//            }
//        }
//    }

    private function wireForm(ContainerBuilder $container, string $class, string $name, string $form): void
    {
        $definitionBridgeCreate = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$name.'.form.rest.'.$form);
        $definitionBridgeCreate->setArgument(1, $class);
    }

    private function wireRepository(ContainerBuilder $container, Reference $registry, string $madiator, string $class, string $driver): void
    {
        $definitionRepository = $container->getDefinition('evrinoma.'.$this->getAlias().'.'.$driver.'.repository');
        $definitionQueryMediator = $container->getDefinition($madiator);
        $definitionRepository->setArgument(0, $registry);
        $definitionRepository->setArgument(1, $class);
        $definitionRepository->setArgument(2, $definitionQueryMediator);
        $container->addDefinitions(['evrinoma.'.$this->getAlias().'.repository' => $definitionRepository]);
        $container->addAliases([MenuCommandRepositoryInterface::class => 'evrinoma.'.$this->getAlias().'.repository']);
        $container->addAliases([MenuQueryRepositoryInterface::class => 'evrinoma.'.$this->getAlias().'.repository']);
    }

    private function wireFactory(ContainerBuilder $container, string $class, string $paramClass): void
    {
        $container->removeDefinition('evrinoma.'.$this->getAlias().'.factory');
        $definitionFactory = new Definition($class);
        $definitionFactory->addArgument($paramClass);
        $alias = new Alias('evrinoma.'.$this->getAlias().'.factory');
        $container->addDefinitions(['evrinoma.'.$this->getAlias().'.factory' => $definitionFactory]);
        $container->addAliases([$class => $alias]);
    }

    private function wireController(ContainerBuilder $container, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.api.controller');
        $definitionApiController->setArgument(4, $class);
    }

    private function wireValidator(ContainerBuilder $container, string $class): void
    {
        $definitionApiController = $container->getDefinition('evrinoma.'.$this->getAlias().'.validator');
        $definitionApiController->setArgument(0, new Reference('validator'));
        $definitionApiController->setArgument(1, $class);
    }

    public function getAlias()
    {
        return EvrinomaMenuBundle::BUNDLE;
    }
}
