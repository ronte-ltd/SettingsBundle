<?php

namespace RonteLtd\SettingsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\Config\FileLocator;

class RonteltdSettingsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration();
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load(sprintf('%s.xml', $config['db_driver']));

        $container->setAlias('ronteltd_settings.settings_manager', $config['service']['settings_manager']);

        $this->remapParametersNamespaces($config, $container, [
            '' => [
                'model_manager_name' => 'ronteltd_settings.model_manager_name',
                'setting_class' => 'ronteltd_settings.model.settings.class',
                'prefix' => 'ronteltd_settings.cache.prefix',
                'lifetime' => 'ronteltd_settings.cache.livetime',
            ],
          ]);

        if ('mongodb' === $config['db_driver']) {
            if (null === $config['model_manager_name']) {
                $container->setAlias('ronteltd_settings.document_manager', new Alias('doctrine.odm.mongodb.document_manager', false));
            } else {
                $container->setAlias('ronteltd_settings.document_manager', new Alias(
                    sprintf('doctrine.odm.%s_mongodb.document_manager',
                    $config['model_manager_name']),
                    false
                ));
            }
        }

        if ('couchdb' === $config['db_driver']) {
            if (null === $config['model_manager_name']) {
                $container->setAlias('ronteltd_settings.document_manager', new Alias('doctrine_couchdb.odm.default_document_manager', false));
            } else {
                $container->setAlias('ronteltd_settings.document_manager', new Alias(
                    sprintf('doctrine.odm.%s_couchdb.document_manager',
                    $config['model_manager_name']),
                    false
                  ));
            }
        }

        if ('cache' === $config['db_driver']) {
            if (null === $config['model_manager_name']) {
                throw new \InvalidArgumentException('Cache driver (alias) MUST be provided via "model_manager_name" property if you are using "cache"');
            } else {
                $container->setAlias('ronteltd_settings.cache', new Alias($config['model_manager_name']));
            }
        }

        if ('orm' === $config['db_driver']) {
            $ormEntityManagerDefinition = $container->getDefinition('ronteltd_settings.entity_manager');
            if (method_exists($ormEntityManagerDefinition, 'setFactory')) {
                $ormEntityManagerDefinition->setFactory(array(new Reference('doctrine'), 'getManager'));
            } else {
                $ormEntityManagerDefinition->setFactoryService('doctrine');
                $ormEntityManagerDefinition->setFactoryMethod('getManager');
            }
        }

    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'ronteltd_settings';
    }

    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (array_key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {
            if ($ns) {
                if (!array_key_exists($ns, $config)) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }

            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    $container->setParameter(sprintf($map, $name), $value);
                }
            }
        }
    }
}
