<?php

namespace OD\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * The default controller class
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class DefaultController extends Controller
{

    /**
     * The index controller
     *
     * @return array The view parameters
     * 
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

}
