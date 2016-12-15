<?php

namespace RonteLtd\SettingsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ronteltd_settings');

        $supportedDrivers = ['orm', 'mongodb', 'propel', 'cache', 'couchdb'];

        $rootNode
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of ' . json_encode($supportedDrivers))
                    ->end()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('setting_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('model_manager_name')->defaultNull()->end()
                ->scalarNode('prefix')->defaultValue('settings.')->end()
                ->integerNode('lifetime')->defaultValue(0)->end()
            ->end();

        $this->addServiceSection($rootNode);

        return $treeBuilder;
    }

    private function addServiceSection(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('service')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('settings_manager')
                                ->defaultValue('ronteltd_settings.settings_manager.default')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
