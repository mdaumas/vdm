<?php

namespace OD\TicketBundle\Service\Loader;

use OD\TicketBundle\Entity\PhoneLine;
use OD\TicketBundle\Entity\OutgoingCall;

/**
 * Outgoing Call csv file reader
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
Class OutgoingLoader extends CsvLoader
{

    const PHONE_LINE = 0;
    const DATE = 1;
    const DURATION = 2;
    const CALLED_NUMBER = 3;
    const NATURE = 4;
    const TYPE = 5;
    const DESTINATION = 6;
    const PRICE = 7;
    const D = 8;
    const T = 9;
    const DESIGNATION = 10;
    const IDKEY = 11;
    const CALLING_NUMBER = 12;
    const DIALED_NUMBER = 13;
    /**
     * Record count
     */
    const RECORD_COUNT = 14;

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
            throw new \RuntimeException(
                sprintf(
                    'Fatal error : bad file line count : expected %s found %s'),
                self::RECORD_COUNT,
                count($fields)
            );
        }

        $outgoingCall = new OutgoingCall();
        $outgoingCall->setPhoneLine($this->getPhoneLine($fields[self::PHONE_LINE]));
        $outgoingCall->setDate($this->getDate($fields[self::DATE]));
        $outgoingCall->setDuration($fields[self::DURATION]);
        $outgoingCall->setCalledNumber($fields[self::CALLED_NUMBER]);
        $outgoingCall->setNature($this->getNature($fields[self::NATURE]));
        $outgoingCall->setType($this->getType($fields[self::TYPE]));
        $outgoingCall->setDestination($fields[self::DESTINATION]);
        $outgoingCall->setPrice($fields[self::PRICE]);
        $outgoingCall->setDesignation($fields[self::DESIGNATION]);
        $outgoingCall->setIdkey($fields[self::IDKEY]);
        $outgoingCall->setCallingNumber($fields[self::CALLING_NUMBER]);
        $outgoingCall->setDialedNumber($fields[self::DIALED_NUMBER]);

        $this->eManager->persist($outgoingCall);

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
     * Return nature enum from nature string
     *
     * @param string $nature
     *
     * @return int OutgoingCall::NATURE
     */
    public function getNature($nature)
    {
        switch ($nature) {
            case 'transfert' :
                return OutgoingCall::NATURE_TRANSFERT;
            case 'national' :
                return OutgoingCall::NATURE_NATIONAL;
            case 'international' :
                return OutgoingCall::NATURE_INTERNATIONAL;
        }

        throw new \Exception('Unknown nature : ' . $nature);
    }

    /**
     * Return type enum from type string
     *
     * @param string $type
     *
     * @return int IncomingCall::NATURE
     */
    public function getType($type)
    {
        switch ($type) {
            case 'landLine' :
                return OutgoingCall::TYPE_LANDLINE;
            case 'mobile' :
                return OutgoingCall::TYPE_MOBILE;
            case 'special' :
                return OutgoingCall::TYPE_SPECIAL;
        }

        throw new \Exception('Unknown type : ' . $type);
    }

}