<?php

namespace OD\LdapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link
 * http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class
 * }
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('od_ldap');

        $rootNode
            ->children()
            ->scalarNode('user_base_dn')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('user_filter')->defaultValue('(objectClass=*)')->end()
            ->scalarNode('username_attribute')->defaultValue('uid')->end()
            ->scalarNode('role_base_dn')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('role_filter')->defaultValue('(objectClass=*)')->end()
            ->scalarNode('role_name_attribute')->defaultValue('cn')->end()
            ->scalarNode('role_user_attribute')->defaultValue('memberuid')->end()
            ->end();

        $this->addClientSection($rootNode);
        $this->addSecuritySection($rootNode);

        return $treeBuilder;
    }

    /**
     * Client Section Node declaration
     *
     * @param \OD\LdapBundle\DependencyInjection\ArrayNodeDefinition $rootNode
     *
     * @return null
     */
    private function addClientSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            // TODO: Add Zend\Ldap configuration structure
            ->variableNode('client')
            ->defaultValue(array())
            ->beforeNormalization()
            ->ifTrue(
                function($v) {
                    return !is_array($v);
                })
            ->thenEmptyArray()
            ->end()
            ->end()
            ->end();
    }

    /**
     * Security Section Node declaration
     *
     * @param \OD\LdapBundle\DependencyInjection\ArrayNodeDefinition $rootNode
     *
     * @return null
     */
    private function addSecuritySection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('security')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('role_prefix')->defaultValue('ROLE_LDAP_')->end()
            ->arrayNode('default_roles')
            ->performNoDeepMerging()
            ->beforeNormalization()->ifString()->then(
                function($v) {
                    return array('value' => $v);
                })->end()
            ->beforeNormalization()
            ->ifTrue(
                function($v) {
                    return is_array($v) && isset($v['value']);
                })
            ->then(
                function($v) {
                    return preg_split('/\s*,\s*/', $v['value']);
                })
            ->end()
            ->prototype('scalar')->end()
            ->end()
            ->end()
            ->end()
            ->end();
    }

}
