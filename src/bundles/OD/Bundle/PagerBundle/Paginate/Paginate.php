<?php

namespace bundles\OD\Bundle\PagerBundle\Paginate;

use Doctrine\ORM\Query;

class Paginate {

    /**
     *
     * @param Query $query
     * @return <type>
     */
    static public function count(Query $query) {

        $countQuery = clone $query;

        $countQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('bundles\OD\Bundle\PagerBundle\Paginate\CountSqlWalker'));
        $countQuery->setFirstResult(null)->setMaxResults(null);

        try {
            $count = $countQuery->getSingleScalarResult();
        } catch (\Exception $e) {

            $count = 0;
        }

        return $count;
    }

}