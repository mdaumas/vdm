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
        $moduleManager = $this->container->get('module.manager');

        $ticketModule = new TicketModule();
        $ticketModule->setName('Ticket');
        $ticketModule->setPath($this->container->getParameter('ticket_src'));
        $ticketModule->setRoutes(array('phoneline_find'));
        $ticketModule->setConfig(array(
            'launcher' => array(
                'text'          => $translator->trans('Gestion des Appels'),
                'iconCls'       => 'tabs'
            ),
            'title'         => $translator->trans('Gestion des Appels'),
            'iconCls'       => 'tabs',
            'toolbarConfig' => array(
                'text'    => $translator->trans('Options'),
                'tooltip' => $translator->trans('Modifier les options')
            ),
            'tabs'    => array(
                'phoneLine' => array(
                    'title' => $translator->trans('Lignes'),
                    'colheaders' => array(
                        'numero' => $translator->trans('Numéro')
                    )
                )
            )
        ));

        $moduleManager->registerModule($ticketModule);
    }

}