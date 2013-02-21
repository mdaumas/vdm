<?php

namespace OD\VdmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use OD\ADBundle\Security\User\AdUser;

/**
 * Vdm Config Controleur Class
 */
class ConfigController extends Controller {

    /**
     * Index controler
     *
     * @return array View parameters
     *
     * @Route("/vdmConfig", name="vdm_config")
     */
    public function vdmConfigAction() {

        $user = $this->getUser();
        $container = $this->container;

        if ($user instanceof AdUser) {
            $mail = $user->getMail();
            $dn = $user->getDn();
            $displayName = $user->getDisplayName();
        } else {
            $admin = $container->getParameter('admin.settings');
            $mail = $admin['mail'];
            $dn = $admin['dn'];
            $displayName = $admin['d'];
        }

        $config = array(
            'config' => array(
                'logoutUrl' => $this->generateUrl('_logout'),
                'loggedUser' => array(
                    "username" => $user->getUsername(),
                    "mail" => $mail,
                    "dn" => $dn,
                    "displayName" => $displayName
                )
            )
        );

        return new Response(json_encode($config));
    }

}
