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
class OutgoingCallController extends Controller
{

    /**
     * The find controller
     *
     * @return string Json result
     *
     * @Route("/outgoing/find", name="outgoingcall_find")
     */
    public function indexAction()
    {
        $eManager = $this->getDoctrine()->getEntityManager();
        $result = array();

        $result = $eManager->getRepository('Ticket:OutgoingCall')->findAllArray();

        return new Response(json_encode(
                    array(
                        "success"    => true,
                        "outgoingcalls" => $result
                    )
                )
        );
    }

}
