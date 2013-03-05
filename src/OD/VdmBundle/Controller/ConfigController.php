<?php

namespace OD\VdmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use OD\ADBundle\Security\User\AdUser;

/**
 * Vdm Config Controleur Class
 *
 */
class ConfigController extends Controller
{

    /**
     * Index controler
     *
     * @return array View parameters
     *
     * @Route("/vdmConfig", name="vdm_config")
     *
     * @SuppressWarnings(PHPMD)
     */
    public function vdmConfigAction()
    {

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
                'settingsLabel'     => $translator->trans('Options'),
                'logoutLabel'       => $logoutLabel,
                'logoutConfirmText' => $translator->trans('Voulez-vous vraiment vous deconnecter?'),
                'logoutDialogTitle' => $logoutLabel,
                'logoutUrl'         => $this->generateUrl('_logout'),
                'loggedUser'        => array(
                    "username"       => $user->getUsername(),
                    "mail"           => $mail,
                    "dn"             => $dn,
                    "displayName"    => $displayName
                ),
                'desktopConfig'  => $this->getDesktopConfig(),
                'settingsConfig' => $this->getSettingsConfig(),
                'taskbarConfig'  => $this->getTaskbarConfig(),
                'trayConfig'     => $this->getTrayConfig(),
                'modulesConfig'  => $this->getModulesConfig()
            )
        );

        return new Response(json_encode($config));
    }

    /**
     * return modules config array
     *
     * @return array
     */
    protected function getModulesConfig()
    {
        $moduleManager = $this->container->get('module.manager.service');

        $modulesConfig = array();
        foreach ($moduleManager->getModules() as $module) {
            $modulesConfig[] = $module->toConfig();
        }

        return $modulesConfig;
    }

    /**
     * return the desktop component configuration
     *
     * @return array configArray(name => value)
     *
     */
    protected function getDesktopConfig()
    {
        $translator = $this->get('translator');

        return array(
            'contextMenuTileLabel'      => $translator->trans('Empiler'),
            'contextMenuCascadeLabel'   => $translator->trans('Cascade'),
            'createWindowRestoreLabel'  => $translator->trans('Restaurer'),
            'createWindowMinimizeLabel' => $translator->trans('Reduire'),
            'createWindowMaximizeLabel' => $translator->trans('Agrandir'),
            'createWindowCloseLabel'    => $translator->trans('Fermer')
        );
    }

    /**
     * return the settings component configuration
     *
     * @return array configArray(name => value)
     */
    protected function getSettingsConfig()
    {
        $translator = $this->get('translator');

        return array(
            'title'             => $translator->trans('Options'),
            'okLabel'           => $translator->trans('Valider'),
            'cancelLabel'       => $translator->trans('Annuler'),
            'stretchLabel'      => $translator->trans('Etirer'),
            'desktopBackground' => $translator->trans('Personnaliser le papier peint'),
            'noneLabel'         => $translator->trans('Aucun'),
            'previewLabel'      => $translator->trans('Apperçu')
        );
    }

    /**
     * return the taskbar component configuration
     *
     * @return array configArray(name => value)
     */
    protected function getTaskbarConfig()
    {
        $translator = $this->get('translator');

        return array(
            'startBtnText' => $translator->trans('Démarrer')
        );
    }

    /**
     * return the tray component configuration
     *
     * @return array configArray(name => value)
     */
    protected function getTrayConfig()
    {

        return array(
            'timeFormat'      => 'H:i:s',
            'updateTimeDelay' => '1000'
        );
    }

}
