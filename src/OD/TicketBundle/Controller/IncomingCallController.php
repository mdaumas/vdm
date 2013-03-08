<?php

namespace OD\TicketBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use bundles\OD\Bundle\PagerBundle\Pager\Pager;

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
    public function findAction()
    {
        $sort = \json_decode($this->get('request')->get('sort'));
        $pager = $this->getFindPager($sort[0]);

        return new Response(json_encode(
                    array(
                        "success"    => true,
                        'totalCount' => $pager->getCount(),
                        'incomingcalls' => $pager->getArrayResult()
                    )
                )
        );
    }

    /**
     * Return a Query Pager
     *
     * @param stdClass $sort the sort parameters
     *
     * @return \OD\TicketBundle\Controller\Pager
     */
    protected function getFindPager($sort)
    {
        $eManager = $this->getDoctrine()->getEntityManager();
        $query = $eManager->getRepository('Ticket:IncomingCall')->findAllQuery($sort);

        $pager = new Pager(
                $query,
                $this->get('request')->get('page', 1),
                $this->get('request')->get('limit', 10)
        );

        return $pager;
    }

}
