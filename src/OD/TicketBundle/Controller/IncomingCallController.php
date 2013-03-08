<?php

namespace OD\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * The IncomingCall controller class
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class IncomingCallController extends Controller
{

    /**
     * The find controller
     *
     * @return string Json result
     *
     * @Route("/incoming/find", name="incomingcall_find")
     */
    public function indexAction()
    {
        $eManager = $this->getDoctrine()->getEntityManager();
        $result = array();

        $result = $eManager->getRepository('Ticket:IncomingCall')->findAllArray();

        return new Response(json_encode(
                    array(
                        "success"    => true,
                        "incomingcalls" => $result
                    )
                )
        );
    }

}
