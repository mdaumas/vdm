<?php

namespace OD\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * In Call
 *
 * OD\TicketBundle\Entity\IncomingCall
 *
 * @ORM\Entity
 *
 * @ORM\Table(name="incoming_call")
 *
 * @ORM\Entity(repositoryClass="OD\TicketBundle\Repository\IncomingCallRepository")
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class IncomingCall
{
    /**
     * Natures
     */

    const NATURE_INCOMING = 1;
    const NATURE_MISS = 2;
    const NATURE_TRANSFERT = 3;

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
     * @ORM\Column(name="calling_number", type="string", length=11)
     */
    private $callingNumber;

    /**
     * @var int
     *
     * @ORM\Column(name="nature", type="smallint", length=1)
     */
    private $nature;

    /**
     * Set idkey
     *
     * @param string $idkey
     *
     * @return InCall
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
     * @return InCall
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
     * @return InCall
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
     * Set callingNumber
     *
     * @param string $callingNumber
     *
     * @return InCall
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
     * Set nature
     *
     * @param integer $nature
     *
     * @return InCall
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
     * Set phoneLine
     *
     * @param \OD\TicketBundle\Entity\PhoneLine $phoneLine
     *
     * @return InCall
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