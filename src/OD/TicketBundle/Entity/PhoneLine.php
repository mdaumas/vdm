<?php

namespace OD\TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Phone Line
 *
 * OD\TicketBundle\Entity\PhoneLine
 *
 * @ORM\Entity
 *
 * @ORM\Table(name="phone_line")
 *
 * @ORM\Entity(repositoryClass="OD\TicketBundle\Repository\PhoneLineRepository")
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class PhoneLine
{

    /**
     * @var string $number
     *
     * @ORM\Id
     * @ORM\Column(name="number", type="string", length=12)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $number;

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return PhoneLine
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

}