<?php

namespace bundles\OD\Bundle\PagerBundle\Pager;

use bundles\OD\Bundle\PagerBundle\Paginate\Paginate;
use Doctrine\ORM\Query;

Class Pager {

    /**
     * Requête à executer
     * @var \Doctrine\ORM\Query
     */
    protected $query;
    protected $count;
    protected $page_size;
    protected $page;
    protected $last_page_in_range;
    protected $first_page_in_range;
    protected $page_in_range_count;
    protected $result;

    public function __construct($query, $page, $page_size, $page_in_range_count = 0) {
        $this->page_in_range_count = $page_in_range_count;
        $this->query = $query;
        $this->setPageSize($page_size);
        $this->setPage($page);
    }

    public function setResult($result) {
        $this->result = $result;
    }

    public function getResult() {
        if (!isset($this->result)) {
            $this->result = $this->query->getResult();
        }

        return $this->result;
    }

    public function getArrayResult() {
        if (!isset($this->result)) {
            $this->result = $this->query->getArrayResult();
        }

        return $this->result;
    }

    /**
     * Executes the query.
     *
     * @param array $params Any additional query parameters.
     * @param integer $hydrationMode Processing mode to be used during the hydration process.
     * @return mixed
     */
    public function execute($params = array(), $hydrationMode = null) {
        if (!isset($this->result)) {
            $this->result = $this->query->execute($params, $hydrationMode);
        }

        return $this->result;
    }

    public function getQuery() {
        return $this->query;
    }

    public function getCount() {
        if (!isset($this->count)) {
            $this->count = Paginate::count($this->query);
        }

        return $this->count;
    }

    public function setCount($count) {

        $this->count = $count;
    }

    public function setPage($page) {
        $this->page = $page;
        if ($this->query instanceof Query) {
            $first_result = ($page - 1) * $this->page_size;
            $first_result = $first_result > 0 ? $first_result : 0;
            $this->query->setFirstResult($first_result);
        }
    }

    public function setPageSize($page_size) {
        $this->page_size = $page_size;
        if ($this->query instanceof Query) {
            $this->query->setMaxResults($page_size);
        }
    }

    public function getPageInRangeCount() {
        return self::PAGE_IN_RANGE_COUNT;
    }

    public function getPageSize() {
        return $this->page_size;
    }

    public function getPage() {
        return $this->page;
    }

    public function getFirstPage() {
        return 1;
    }

    public function getLastPage() {
        return ceil($this->count / $this->page_size);
    }

    public function getPrevious() {
        return $this->page - 1 > 0 ? $this->page - 1 : null;
    }

    public function getNext() {
        return $this->page + 1 <= $this->getLastPage() ? $this->page + 1 : null;
    }

    public function getLastPageInRange() {
        return $this->last_page_in_range;
    }

    public function getFirstPageInRange() {
        return $this->first_page_in_range;
    }

    public function pagesInRange() {
        $pages = $this->getLastPage();
        $page_count = $pages < $this->page_in_range_count ? $pages : $this->page_in_range_count;

        $pranges = array();
        $nranges = array();
        $prange = $this->page - 1;
        $nrange = $this->page + 1;
        $reste = $this->getLastPage() - $this->getPage() >= $this->page_in_range_count ? $this->page_in_range_count : $this->getLastPage() - $this->getPage();
        $pcount = 2 * $page_count - $reste;
        for ($count = 0; $count < $pcount; $count++) {
            if ($prange > 0) {
                $pranges[] = $prange;
            }
            $prange--;
        }

        $rcount = 2 * $page_count - count($pranges);
        for ($count = 0; $count < $rcount; $count++) {
            if ($nrange <= $pages) {
                $nranges[] = $nrange;
            }
            $nrange++;
        }

        $ranges = array();
        foreach ($pranges as $prange) {
            $ranges[] = $prange;
        }

        $ranges = array_reverse($ranges);

        $ranges[] = $this->page;

        foreach ($nranges as $nrange) {
            $ranges[] = $nrange;
        }

        $this->first_page_in_range = $ranges[0];
        $this->last_page_in_range = $ranges[count($ranges) - 1];

        return $ranges;
    }

}