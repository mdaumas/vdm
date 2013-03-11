<?php

namespace bundles\OD\Bundle\PagerBundle\Paginate;

use Doctrine\ORM\Query\TreeWalkerAdapter;
use Doctrine\ORM\Query\AST\SelectStatement;
use Doctrine\ORM\Query\AST\PathExpression;
use Doctrine\ORM\Query\AST\SelectExpression;
use Doctrine\ORM\Query\AST\AggregateExpression;

/**
 * Replaces the selectClause of the AST with a COUNT statement
 *
 * @author Marc Daumas <mdaumad@objetdirect.com>
 *
 * @SuppressWarnings(PHPMD)
 */
class CountSqlWalker extends TreeWalkerAdapter
{

    /**
     * Walks down a SelectStatement AST node, modifying it to retrieve a COUNT
     *
     * @param SelectStatement $ast
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD)
     */
    public function walkSelectStatement(SelectStatement $ast)
    {
        $rootComponents = array();
        foreach ($this->_getQueryComponents() as $dqlAlias => $qComp) {
            $isParent = array_key_exists('parent', $qComp)
                && $qComp['parent'] === null
                && $qComp['nestingLevel'] == 0
            ;
            if ($isParent) {
                $rootComponents[] = array($dqlAlias => $qComp);
            }
        }
        if (count($rootComponents) > 1) {
            throw new \RuntimeException(
                "Cannot count query which selects two FROM components, cannot make distinction"
            );
        }
        $root = reset($rootComponents);
        $parentName = key($root);
        $parent = current($root);

        $pathExpression = new PathExpression(
                PathExpression::TYPE_STATE_FIELD | PathExpression::TYPE_SINGLE_VALUED_ASSOCIATION, $parentName,
                $parent['metadata']->getSingleIdentifierFieldName()
        );
        $pathExpression->type = PathExpression::TYPE_STATE_FIELD;

        $distinct = $this->_getQuery()->getHint(\Doctrine\ORM\Tools\Pagination\CountWalker::HINT_DISTINCT);
        $aggregationExpression = new AggregateExpression('count', $pathExpression, $distinct);
        $selectExpression = new SelectExpression($aggregationExpression, null);
        $ast->selectClause->selectExpressions = array($selectExpression);

        // ORDER BY is not needed, only increases query execution through unnecessary sorting.
        $ast->orderByClause = null;
    }

}