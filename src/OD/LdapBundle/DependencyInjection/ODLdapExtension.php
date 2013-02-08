<?php

namespace OD\LdapBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\Definition\Processor;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ODLdapExtension extends Extension
{

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('ldap.yml');

        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        $container->setParameter('od_ldap.client.options', $config['client']);

        $params = array(
            'user_base_dn',
            'user_filter',
            'username_attribute',
            'role_base_dn',
            'role_filter',
            'role_name_attribute',
            'role_user_attribute'
        );

        foreach ($params as $key) {
            $container->setParameter('od_ldap.user_manager.' . $key, $config[$key]);
        }

        foreach (array('role_prefix', 'default_roles') as $key) {
            $container->setParameter('od_ldap.user_provider.' . $key, $config['security'][$key]);
        }
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    public function getAlias()
    {
        return 'od_ldap';
    }

}
