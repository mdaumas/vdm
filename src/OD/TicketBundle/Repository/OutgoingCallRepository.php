<?php

namespace OD\TicketBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * OutgoingCallRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OutgoingCallRepository extends EntityRepository
{

    /**
     * Find all phone lines
     *
     * @param stdClass $sort
     *
     * @return array
     */
    public function findAllQuery($sort)
    {
        $qBuilder = $this->_em->createQueryBuilder()
            ->select("
                o.idkey,
                DATE_FORMAT(o.date, '%d/%m/%Y %H:%i:%s') as date,
                o.duration,
                o.calledNumber,
                o.nature,
                o.type,
                o.destination,
                o.price,
                o.designation,
                o.callingNumber,
                o.dialedNumber,
                pl.number as phoneLine")
            ->from('Ticket:OutgoingCall', 'o')
            ->leftJoin('o.phoneLine', 'pl');

        if ($sort) {
            $prefix = $sort->property == 'number' ? 'pl.' : 'o.';
            $qBuilder->addOrderBy($prefix . $sort->property, $sort->direction);
        }

        return $qBuilder->getQuery();
    }

}
