<?php

namespace OD\ADBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use OD\ADBundle\Security\Factory\AdAuthFactory;

/**
 * Bundle initialization class
 */
class ODADBundle extends Bundle
{

    /**
     * Initialize the bundle
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new AdAuthFactory());
    }

}
