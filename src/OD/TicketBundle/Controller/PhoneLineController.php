<?php

namespace OD\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * The PhoneLine controller class
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class PhoneLineController extends Controller
{

    /**
     * The find controller
     *
     * @return string Json result
     *
     * @Route("/phoneline/find", name="phoneline_find")
     */
    public function indexAction()
    {
        $eManager = $this->getDoctrine()->getEntityManager();
        $result = array();

        $result = $eManager->getRepository('ODTicketBundle:PhoneLine')->findAllArray();

        return new Response(json_encode(
                    array(
                        "success"    => true,
                        "phonelines" => $result
                    )
                )
        );
    }

}
