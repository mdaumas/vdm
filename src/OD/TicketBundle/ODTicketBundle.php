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
        $ticketModule->setRoutes(array(
            'phoneline_find',
            'incomingcall_find',
            'outgoingcall_find'
            )
        );
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
                    'title'      => $translator->trans('Lignes'),
                    'colheaders' => array(
                        'numero'       => $translator->trans('Numéro')
                    )
                ),
                'incomingCall' => array(
                    'title'      => $translator->trans('Appels Entrants'),
                    'colheaders' => array(
                        'idkey'         => $translator->trans('Clé'),
                        'phoneline'     => $translator->trans('Ligne'),
                        'date'          => $translator->trans('date'),
                        'duration'      => $translator->trans('Durée'),
                        'callingNumber' => $translator->trans('Numéro Appelant'),
                        'nature'        => $translator->trans('Nature')
                    )
                ),
                'outgoingCall'  => array(
                    'title'      => $translator->trans('Appels Sortans'),
                    'colheaders' => array(
                        'idkey'         => $translator->trans('Clé'),
                        'phoneline'     => $translator->trans('Ligne'),
                        'date'          => $translator->trans('date'),
                        'duration'      => $translator->trans('Durée'),
                        'calledNumber'  => $translator->trans('Numéro Appelé'),
                        'nature'        => $translator->trans('Nature'),
                        'type'          => $translator->trans('Type'),
                        'destination'   => $translator->trans('Destination'),
                        'price'         => $translator->trans('Prix'),
                        'designation'   => $translator->trans('Designation'),
                        'callingNumber' => $translator->trans('Numéro Appelant'),
                        'dialedNumber'  => $translator->trans('Numéro Composé'),
                    )
                )
            )
        ));

        $moduleManager->registerModule($ticketModule);
    }

}