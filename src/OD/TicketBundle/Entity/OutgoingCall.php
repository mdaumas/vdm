<?php

namespace OD\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Out Phone Call
 *
 * OD\TicketBundle\Entity\OutgoingCall
 *
 * @ORM\Entity
 *
 * @ORM\Table(name="outgoing_call",indexes={
 *     @ORM\Index(name="nature_idx", columns={"nature"}),
 *     @ORM\Index(name="type_idx", columns={"type"})
 * })
 * @ORM\Entity(repositoryClass="OD\TicketBundle\Repository\OutgoingCallRepository")
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class OutgoingCall
{
    /**
     * Natures
     */

    const NATURE_TRANSFERT = 1;
    const NATURE_NATIONAL = 2;
    const NATURE_INTERNATIONAL = 3;

    /**
     * Types
     */
    const TYPE_LANDLINE = 1;
    const TYPE_SPECIAL = 2;
    const TYPE_MOBILE = 3;

    /**
     * @var string $idkey
     *
     * @ORM\Id
     * @ORM\Column(name="idkey", type="string", length=10)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idkey;

    /**
     *
     * @var OD\TicketBundle\Entity\PhoneLine
     *
     * @ORM\ManyToOne(targetEntity="OD\TicketBundle\Entity\PhoneLine")
     * @ORM\JoinColumn(name="phone_line", referencedColumnName="number", onDelete="cascade")
     */
    private $phoneLine;

    /**
     * @var date
     *
     * @ORM\Column(name="date", type="datetime")
     *
     */
    private $date;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="duration", type="integer", length=4)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="called_number", type="string", length=11)
     */
    private $calledNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="nature", type="smallint", length=1)
     */
    private $nature;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="smallint", length=1)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=50)
     */
    private $destination;

    /**
     * @var decimal
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @var designation
     *
     * @ORM\Column(name="designation", type="string", length=5)
     */
    private $designation;

    /**
     * @var string
     *
     * @ORM\Column(name="calling_number", type="string", length=11)
     */
    private $callingNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="dialed_number", type="string", length=11)
     */
    private $dialedNumber;

    /**
     * Set idkey
     *
     * @param string $idkey
     *
     * @return OutCall
     */
    public function setIdkey($idkey)
    {
        $this->idkey = $idkey;

        return $this;
    }

    /**
     * Get idkey
     *
     * @return string
     */
    public function getIdkey()
    {
        return $this->idkey;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return OutCall
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return OutCall
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set calledNumber
     *
     * @param string $calledNumber
     *
     * @return OutCall
     */
    public function setCalledNumber($calledNumber)
    {
        $this->calledNumber = $calledNumber;

        return $this;
    }

    /**
     * Get calledNumber
     *
     * @return string
     */
    public function getCalledNumber()
    {
        return $this->calledNumber;
    }

    /**
     * Set nature
     *
     * @param integer $nature
     *
     * @return OutCall
     */
    public function setNature($nature)
    {
        $this->nature = $nature;

        return $this;
    }

    /**
     * Get nature
     *
     * @return integer
     */
    public function getNature()
    {
        return $this->nature;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return OutCall
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set destination
     *
     * @param string $destination
     *
     * @return OutCall
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;

        return $this;
    }

    /**
     * Get destination
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return OutCall
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set designation
     *
     * @param string $designation
     *
     * @return OutCall
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set callingNumber
     *
     * @param string $callingNumber
     *
     * @return OutCall
     */
    public function setCallingNumber($callingNumber)
    {
        $this->callingNumber = $callingNumber;

        return $this;
    }

    /**
     * Get callingNumber
     *
     * @return string
     */
    public function getCallingNumber()
    {
        return $this->callingNumber;
    }

    /**
     * Set dialedNumber
     *
     * @param string $dialedNumber
     *
     * @return OutCall
     */
    public function setDialedNumber($dialedNumber)
    {
        $this->dialedNumber = $dialedNumber;

        return $this;
    }

    /**
     * Get dialedNumber
     *
     * @return string
     */
    public function getDialedNumber()
    {
        return $this->dialedNumber;
    }

    /**
     * Set phoneLine
     *
     * @param \OD\TicketBundle\Entity\PhoneLine $phoneLine
     *
     * @return OutCall
     */
    public function setPhoneLine(\OD\TicketBundle\Entity\PhoneLine $phoneLine = null)
    {
        $this->phoneLine = $phoneLine;

        return $this;
    }

    /**
     * Get phoneLine
     *
     * @return \OD\TicketBundle\Entity\PhoneLine
     */
    public function getPhoneLine()
    {
        return $this->phoneLine;
    }

}