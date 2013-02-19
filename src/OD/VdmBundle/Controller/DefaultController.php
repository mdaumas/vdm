<?php

namespace OD\VdmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Defaut Controleur Class
 */
class DefaultController extends Controller {

    /**
     * Index controler
     *
     * @return array View parameters
     *
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction() {

        return array();
    }

    /**
     * @Route("/logged_user", name="logged_user")
     */
    public function loggedUserAction() {
        $response = new Response();

        $user = $this->getUser();

        $content = json_encode(
                array(
                    "success" => true,
                    "users" => array(
                        "id" => 0,
                        "username" => $user->getUsername(),
                        "mail" => $user->getMail(),
                        "dn" => $user->getDn(),
                        "displayName" => $user->getDisplayName()
                )));
        
        return $response->setContent($content);
    }

}
