<?php

namespace OD\VdmBundle\Service;

/**
 * Configuration manager for Vdm application
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 *
 * @SuppressWarnings(PHPMD)
 */
class ConfigManager
{

    /**
     * The module manager
     *
     * @var ModuleManager
     */
    protected $moduleManager;

    /**
     * The translator service
     *
     * @var Translator
     */
    protected $translator;

    /**
     * The service container
     *
     * @var ContainerInterface
     */
    protected $container;

    /**
     * The controller
     *
     * @var Controller
     */
    protected $controller;

    /**
     * The configuration user username
     *
     * @var string
     */
    protected $username;
    /**
     * The configuration user mail
     *
     * @var string
     */
    protected $mail;

    /**
     * The configuration user dn
     *
     * @var string
     *
     * @SuppressWarnings(PHPMD)
     */
    protected $dn;

    /**
     * The configuration display name
     * @var type
     */
    protected $displayName;

    /**
     * Constructor
     *
     * @param ModuleManager      $moduleManager
     * @param Translator         $translator
     * @param ContainerInterface $container
     */
    public function __construct($moduleManager, $translator, $container)
    {
        $this->moduleManager = $moduleManager;
        $this->translator = $translator;
        $this->container = $container;
    }

    /**
     * Build the complete desktop application configuration array
     *
     * @return array The configuration array
     */
    public function buildConfig()
    {
        $logoutLabel = $this->translator->trans('Deconnexion');

        $config = array(
            'config' => array(
                'settingsLabel'     => $this->translator->trans('Options'),
                'logoutLabel'       => $logoutLabel,
                'logoutConfirmText' => $this->translator->trans('Voulez-vous vraiment vous deconnecter?'),
                'logoutDialogTitle' => $logoutLabel,
                'logoutUrl'         => $this->controller->generateUrl('_logout'),
                'loggedUser'        => array(
                    "username"       => $this->getUsername(),
                    "mail"           => $this->getMail(),
                    "dn"             => $this->getDn(),
                    "displayName"    => $this->getDisplayName()
                ),
                'desktopConfig'  => $this->getDesktopConfig(),
                'settingsConfig' => $this->getSettingsConfig(),
                'taskbarConfig'  => $this->getTaskbarConfig(),
                'trayConfig'     => $this->getTrayConfig(),
                'modulesConfig'  => $this->getModulesConfig()
            )
        );

        return $config;
    }

    /**
     * Return modules config array
     *
     * @return array
     */
    protected function getModulesConfig()
    {
        $moduleManager = $this->moduleManager;

        $modulesConfig = array();
        foreach ($moduleManager->getModules() as $module) {
            $modulesConfig[] = $module->toConfig();
        }

        return $modulesConfig;
    }

    /**
     * Return the desktop component configuration
     *
     * @return array configArray(name => value)
     *
     */
    protected function getDesktopConfig()
    {

        return array(
            'contextMenuTileLabel'      => $this->translator->trans('Empiler'),
            'contextMenuCascadeLabel'   => $this->translator->trans('Cascade'),
            'createWindowRestoreLabel'  => $this->translator->trans('Restaurer'),
            'createWindowMinimizeLabel' => $this->translator->trans('Reduire'),
            'createWindowMaximizeLabel' => $this->translator->trans('Agrandir'),
            'createWindowCloseLabel'    => $this->translator->trans('Fermer')
        );
    }

    /**
     * return the settings component configuration
     *
     * @return array configArray(name => value)
     */
    protected function getSettingsConfig()
    {

        return array(
            'title'             => $this->translator->trans('Options'),
            'okLabel'           => $this->translator->trans('Valider'),
            'cancelLabel'       => $this->translator->trans('Annuler'),
            'stretchLabel'      => $this->translator->trans('Etirer'),
            'desktopBackground' => $this->translator->trans('Personnaliser le papier peint'),
            'noneLabel'         => $this->translator->trans('Aucun'),
            'previewLabel'      => $this->translator->trans('Apperçu'),
            'wallpaperLocation' => $this->container->getParameter('wallpaper_location')
        );
    }

    /**
     * return the taskbar component configuration
     *
     * @return array configArray(name => value)
     */
    protected function getTaskbarConfig()
    {

        return array(
            'startBtnText' => $this->translator->trans('Démarrer')
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

    /**
     * Accessor
     *
     * @return string
     */
    public function getMail()
    {

        return $this->mail;
    }

    /**
     * Accessor
     *
     * @param string $mail
     */
    public function setMail($mail)
    {

        $this->mail = $mail;
    }

    /**
     * Accessor
     *
     * @return string
     */
    public function getDn()
    {

        return $this->dn;
    }

    /**
     * Accessor
     *
     * @param string $dn
     *
     * @SuppressWarnings(PHPMD)
     */
    public function setDn($dn)
    {

        $this->dn = $dn;
    }

    /**
     * Accessor
     *
     * @return string
     */
    public function getDisplayName()
    {

        return $this->displayName;
    }

    /**
     * Accessor
     *
     * @param string $displayName
     */
    public function setDisplayName($displayName)
    {

        $this->displayName = $displayName;
    }

    /**
     * Accessor
     *
     * @return string
     */
    public function getUsername()
    {

        return $this->username;
    }

    /**
     * Accessor
     *
     * @param string $username
     */
    public function setUsername($username)
    {

        $this->username = $username;
    }

    /**
     * Accessor
     *
     * @return string
     */
    public function getController()
    {

        return $this->controller;
    }

    /**
     * Accessor
     *
     * @param string $controller
     */
    public function setController($controller)
    {

        $this->controller = $controller;
    }

}
