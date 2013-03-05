<?php

namespace OD\VdmBundle\Service;

use OD\VdmBundle\Module\VdmModule;
use OD\VdmBundle\Module\VdmModuleAlreadyRegisteredException;

/**
 * Vdm Module management class
 */
class ModuleManagerService
{

    /**
     * The modules to register
     *
     * @var array modules(moduleName => module)
     */
    private $modules = array();

    /**
     * Vdm Module Registration
     *
     * @param type $module
     */
    public function registerModule(VdmModule $module)
    {
        if (isset($this->modules[$module->getName()])) {
            throw new VdmModuleAlreadyRegisteredException($module->getName());
        }

        $this->modules[$module->getName()] = $module;
    }

    /**
     * Accessor
     *
     * @return array the registered modules array
     */
    public function getModules()
    {

        return $this->modules;
    }

}
