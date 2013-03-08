<?php

namespace OD\TicketBundle\Lib\DqlFunction;

use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\SqlWalker;

/**
 * DateFormat
 *
 * Permet à Doctrine d'executer la fonction MySQL DATE_FORMAT
 *
 * DATE_FORMAT(DateExpression,'%format')
 *
 * @author Marc Daumas <mdaumas@objetdirect.com>
 */
class DateFormat extends FunctionNode
{
    /*
     * Le paramètre "expression" de DATE_FORMAT
     * @var mixed
     */

    protected $dateExpression;

    /**
     * Le paramètre '%format' de DATE_FORMAT
     * @var string
     */
    protected $formatChar;

    /**
     * {@inheritdoc}
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'DATE_FORMAT(' .
            $sqlWalker->walkArithmeticExpression($this->dateExpression) .
            ',' .
            $sqlWalker->walkStringPrimary($this->formatChar) .
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
        $parser->match(Lexer::T_COMMA);


        $this->formatChar = $parser->StringPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

}

