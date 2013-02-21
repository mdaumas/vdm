<?php

namespace OD\VdmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Defaut Controleur Class
 */
class DefaultController extends Controller {

    /**
     * Index controler
     *
     * @return array View parameters
     *
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction() {

        $vdmSrc = $this->container->getParameter('vdm_src');
        
        return array(
            'vdm_src' => $vdmSrc,
            'ext_src' => $vdmSrc
        );
    }

}
