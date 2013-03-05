<?php

namespace OD\TicketBundle\Service\Loader;

use OD\TicketBundle\Entity\PhoneLine;
use OD\TicketBundle\Entity\IncomingCall;

/**
 * Incoming Call csv file reader
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
Class IncomingLoader extends CsvLoader
{

    const PHONE_LINE = 0;
    const DATE = 1;
    const DURATION = 2;
    const CALLING_NUMBER = 3;
    const NATURE = 4;
    const D = 5;
    const T = 6;
    const IDKEY = 7;
    const RECORD_COUNT = 8;

    /**
     * The entity manager
     * @var EntityManager
     */
    protected $eManager;

    /**
     * The PhoneLine repository
     * @var PhoneLineRepository
     */
    protected $phoneLineRepo;

    /**
     * The PhoneLine array
     * @var array
     */
    protected $phoneLines = array();

    /**
     * Constructeur
     *
     * @param EntityManager $eManager
     */
    public function __construct($eManager)
    {
        parent::__construct();
        $this->eManager = $eManager;
        $this->phoneLineRepo = $eManager->getRepository('ODTicketBundle:PhoneLine');
    }

    /**
     * Chargement d'une ligne du fichier
     *
     * @param array $fields
     */
    public function loadLine($fields)
    {
        if (count($fields) != self::RECORD_COUNT) {
            throw new \RuntimeException('Fatal error : bad file format');
        }

        $incomingCall = new IncomingCall();
        $incomingCall->setPhoneLine($this->getPhoneLine($fields[self::PHONE_LINE]));
        $incomingCall->setDate($this->getDate($fields[self::DATE]));
        $incomingCall->setDuration($fields[self::DURATION]);
        $incomingCall->setCallingNumber($fields[self::CALLING_NUMBER]);
        $incomingCall->setNature($this->getNature($fields[self::NATURE]));
        $incomingCall->setIdkey($fields[self::IDKEY]);

        $this->eManager->persist($incomingCall);

        $this->parsed++;
    }

    /**
     * {@inheritdoc}
     */
    public function end()
    {
        $this->eManager->flush();
    }

    /**
     * Return a PhoneLine from a number
     *
     * @param type $number
     *
     * @return \OD\TicketBundle\Service\Loader\PhoneLine
     */
    protected function getPhoneLine($number)
    {

        if (isset($this->phoneLines[$number])) {

            return $this->phoneLines[$number];
        }

        $phoneLine = $this->phoneLineRepo->find($number);

        if (!$phoneLine) {
            $phoneLine = new PhoneLine();
            $phoneLine->setNumber($number);
            $this->eManager->persist($phoneLine);
        }

        $this->phoneLines[$number] = $phoneLine;

        return $phoneLine;
    }

    /**
     * Retourne un champ datetime sous la forme YYYY-MM-DD H:i:s
     * @param string $date
     *
     * @return \DateTime
     */
    protected function getDate($date)
    {
        $year = substr($date, 0, 4);
        $month = substr($date, 4, 2);
        $day = substr($date, 6, 2);
        $hour = substr($date, 8, 2);
        $min = substr($date, 10, 2);
        $sec = substr($date, 12, 2);

        return new \DateTime($year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':' . $sec);
    }

    /**
     * Set EntityManager to use
     *
     * @param string $nature
     *
     * @return int IncomingCall::NATURE
     */
    public function getNature($nature)
    {
        switch($nature){
            case 'incoming' :
                return IncomingCall::NATURE_INCOMING;
            case 'miss' :
                return IncomingCall::NATURE_MISS;
            case 'transfert' :
                return IncomingCall::NATURE_TRANSFERT;
        }

        throw new Exception('Unknown nature : ' + $nature);
    }



}