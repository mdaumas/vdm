<?php

namespace OD\TicketBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use OD\TicketBundle\Module\TicketModule;

/**
 * OD Tocket BNundle Class
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class ODTicketBundle extends Bundle
{

    /**
     * Register Ticket Module Object Configuration
     */
    public function boot()
    {
        $translator = $this->container->get('translator');
        $moduleManagerService = $this->container->get('module.manager.service');

        $ticketModule = new TicketModule();
        $ticketModule->setName('Ticket');
        $ticketModule->setPath($this->container->getParameter('ticket_src'));
        $ticketModule->setConfig(array(
            'launcher' => array(
                'text' => $translator->trans('Gestion des Tickets'),
                'iconCls' => 'tabs'
            )
        ));

        $moduleManagerService->registerModule($ticketModule);
    }

}