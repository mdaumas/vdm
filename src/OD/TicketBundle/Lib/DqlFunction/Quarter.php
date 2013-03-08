<?php

namespace OD\TicketBundle\Lib\DqlFunction;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;

/**
 * DateFormat
 *
 * Permet à Doctrine d'executer la fonction MySQL QUARTER
 *
 * QUARTER(DateExpression)
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class Quarter extends FunctionNode
{
    /*
     * Le paramètre DateExpression de MySQL QUARTER
     * @var mixed
     */

    protected $dateExpression;

    /**
     * {@inheritdoc}
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'QUARTER(' .
            $sqlWalker->walkArithmeticExpression($this->dateExpression) .
            ')';
    }

    /**
     * {@inheritdoc}
     */
    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {

        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $this->dateExpression = $parser->ArithmeticExpression();

        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

}