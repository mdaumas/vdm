<?php

namespace OD\ADBundle\Security\Factory;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\FormLoginFactory;

/**
 * Authentication factory class
 *
 * @SuppressWarnings(PHPMD)
 */
class AdAuthFactory extends FormLoginFactory
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->addOption('account_suffix', 'domain.local');
    }

    /**
     * Subclasses must return the id of a service which implements the
     * AuthenticationProviderInterface.
     *
     * @param ContainerBuilder $container      The container
     * @param string           $id             The unique id of the firewall
     * @param array            $config         The options array for this listener
     * @param string           $userProviderId The id of the user provider
     *
     * @return string never null, the id of the authentication provider
     */
    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {

        $providerId = 'security.authentication.provider.active_directory.' . $id;
        $container
            ->setDefinition($providerId,
                new DefinitionDecorator('active.directory.authentication.provider'))
            ->replaceArgument(0, new Reference("active.directory.user.provider"))
            ->replaceArgument(1, $config);

        return $providerId;
    }


    /**
     * {@inheritDoc}
     */
    public function getKey()
    {
        return 'active_directory';
    }

}