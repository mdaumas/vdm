<?php

namespace OD\LdapBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use OD\LdapBundle\DependencyInjection\ODLdapExtension;

/**
 * Bundle definition class
 */
class ODLdapBundle extends Bundle
{

    /**
     * Create the bundle extension
     */
    public function __construct()
    {
        $this->extension = new ODLdapExtension();
    }

}
