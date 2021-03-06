<?php


namespace Evrinoma\MenuBundle\DependencyInjection;

use Evrinoma\MenuBundle\EvrinomaMenuBundle;
use Evrinoma\MenuBundle\Knp\OverrideMenuFactory;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class EvrinomaMenuBundleExtension
 *
 * @package Evrinoma\MenuBundle\DependencyInjection
 */
class EvrinomaMenuBundleExtension extends Extension
{
//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if ($container->has('knp_menu.factory')) {
            throw new InvalidConfigurationException(sprintf('Found the service of registered as \'knp_menu.factory\', could\'t override alias.'));
        }

        $definition = new Definition(OverrideMenuFactory::class);
        $definition->addTag('knp_menu.factory');
        $alias = new Alias('knp_menu.factory');

        $container->addDefinitions(['knp_menu.factory' => $definition]);
        $container->addAliases([OverrideMenuFactory::class => $alias]);
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaMenuBundle::MENU_BUNDLE;
    }
//endregion Getters/Setters
}