<?php

namespace OD\TicketBundle\Service\Loader;

/**
 * Generic csv file loader
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
abstract class CsvLoader
{

    protected $file;
    protected $linesToSkip;
    protected $separator;
    public $parsed;
    public $count;
    public $messages = array();
    public $errors = array();

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->linesToSkip = 0;
        $this->separator = ';';
        $this->count = 0;
        $this->parsed = 0;
    }

    /**
     * Called for each file line read
     *
     * @param array $fields
     */
    public abstract function loadLine($fields);

    /**
     * Called at the end of the file reading
     */
    public abstract function end();

    /**
     * Set the file to load
     *
     * @param type $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Delete datas before loading
     *
     * @param boolean $del
     */
    public function setDeleteCurrentData($del)
    {
        $this->deleteCurrentData = $del;
    }

    /**
     * Set separator character
     *
     * @param string $sep
     */
    public function setSeparator($sep)
    {
        $this->separator = $sep;
    }

    /**
     * Number of lines to skip before read
     * @param int $skip
     */
    public function setSkipLines($skip)
    {
        $this->linesToSkip = $skip;
    }

    /**
     * Chargement du fichier $file
     */
    public function load()
    {
        if (!file_exists($this->file)) {
            throw new \RuntimeException('File does not exists');
        }

        $lines = file($this->file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            throw new \RuntimeException('Cannot open file for read');
        }

        $count = count($lines);
        for ($i = $this->linesToSkip; $i < $count; $i++) {
            if (strlen($lines[$i]) > 0) {
                $this->loadLine(explode($this->separator, $lines[$i]));
                $this->count++;
            }
        }

        $this->end();
    }

}