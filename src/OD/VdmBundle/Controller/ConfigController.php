<?php

namespace OD\VdmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use OD\ADBundle\Security\User\AdUser;

/**
 * Vdm Config Controleur Class
 *
 */
class ConfigController extends Controller
{

    /**
     * Controller for Vdm Desktop application configuration
     *
     * @return array View parameters
     *
     * @Route("/vdmConfig", name="vdm_config")
     */
    public function vdmConfigAction()
    {

        $configManager = $this->get('config.manager');

        $user = $this->getUser();
        $container = $this->container;

        if ($user instanceof AdUser) {
            $configManager->setUsername($user->getUsername());
            $configManager->setMail($user->getMail());
            $configManager->setDn($user->getDn());
            $configManager->setDisplayName($user->getDisplayName());
        } else {
            $admin = $container->getParameter('admin.settings');
            $configManager->setMail($admin['username']);
            $configManager->setMail($admin['mail']);
            $configManager->setDn($admin['dn']);
            $configManager->setDisplayName($admin['displayName']);
        }

        $configManager->setController($this);

        return new Response(json_encode($configManager->buildConfig()));
    }

}
