<?php

namespace OD\VdmBundle\Module;
/**
 * VdmModuleAlreadyRegisteredException
 *
 * Exception for multiple module name registration
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class VdmModuleAlreadyRegisteredException extends \Exception
{

    /**
     * Constructor
     *
     * @param string $moduleName The module name
     */
    public function __construct($moduleName)
    {
        $this->message = sprintf("Module name %s already registered", $moduleName);
    }

}
