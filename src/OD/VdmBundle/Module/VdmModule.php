<?php

namespace OD\VdmBundle\Module;

/**
 * Description of VdmModule
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
abstract class VdmModule
{

    /**
     * The module name
     *
     * @var string
     */
    private $name;

    /**
     * The module javascript path
     * @var type
     */
    private $path;

    /**
     * The module config array
     *
     * @var array array('name', 'value')
     */
    private $config = array();

    /**
     * Accessor
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Accessor
     *
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Accessor
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     *  Accessor
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Accessor
     *
     * @param array $config the config array
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     *  Accessor
     *
     * @return type
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Convert object to config
     *
     * @return array
     */
    public function toConfig()
    {

        return array_merge(array(
                'name' => $this->name,
                'path' => $this->path
                ), $this->config
        );
    }

}