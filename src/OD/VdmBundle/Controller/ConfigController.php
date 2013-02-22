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

        $translator = $this->get('translator');
        $logoutLabel = $translator->trans('Deconnexion');

        $config = array(
            'config' => array(
                'settingsLabel' => $translator->trans('Options'),
                'logoutLabel' => $logoutLabel,
                'logoutConfirmText' => $translator->trans('Voulez-vous vraiment vous deconnecter?'),
                'logoutDialogTitle' => $logoutLabel,
                'logoutUrl' => $this->generateUrl('_logout'),
                'loggedUser' => array(
                    "username" => $user->getUsername(),
                    "mail" => $mail,
                    "dn" => $dn,
                    "displayName" => $displayName
                ),
                'desktopConfig' => array(
                    'contextMenuTileLabel' => $translator->trans('Empiler'),
                    'contextMenuCascadeLabel' => $translator->trans('Cascade'),
                    'createWindowRestoreLabel' => $translator->trans('Restaurer'),
                    'createWindowMinimizeLabel' => $translator->trans('Reduire'),
                    'createWindowMaximizeLabel' => $translator->trans('Agrandir'),
                    'createWindowCloseLabel' => $translator->trans('Fermer')
                ),
                'settingsConfig' => array(
                    'title' => $translator->trans('Options'),
                    'okLabel' => $translator->trans('Valider'),
                    'cancelLabel' => $translator->trans('Annuler'),
                    'stretchLabel' => $translator->trans('Etirer'),
                    'desktopBackground' => $translator->trans('Personnaliser le papier peint'),
                    'noneLabel' => $translator->trans('Aucun'),
                    'previewLabel' => $translator->trans('Apperçu')
                ),
                'taskbarConfig' => array(
                    'startBtnText' => $translator->trans('Démarrer')
                ),
                'trayConfig' => array(
                    'timeFormat' => 'H:i:s',
                    'updateTimeDelay' => '1000'
                )
            )
        );

        return new Response(json_encode($config));
    }

}
