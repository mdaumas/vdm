<?php

namespace OD\ADBundle\Service;

use adLDAP\adLDAP;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The Active Directory Ldap Service Class
 */
class AdLdapService
{

    /**
     * @var adLDAP The instance of adLdap used for each call of the service
     */
    private $adLdap;

    /**
     * Construction
     *
     * @param ContainerInterface $container dependency injection
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $parameters = $container->getParameter('active_directory.settings');
        $parameters['account_suffix'] = '@' . $parameters['account_suffix'];
        $this->paramerters = $parameters;
    }

    /**
     * @return adLDAP The instance of the adLdap (lib)
     */
    public function getInstance()
    {
        $this->adLdap = new adLDAP($this->paramerters);
        
        return $this->adLdap;
    }

}