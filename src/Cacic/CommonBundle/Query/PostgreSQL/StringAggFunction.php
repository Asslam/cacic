<?php
/**
 * Created by PhpStorm.
 * User: eduardo
 * Date: 26/06/14
 * Time: 00:08
 */

namespace Cacic\CommonBundle\Query\PostgreSQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;

/**
 * Class StringAggFunction
 * @package Cacic\CommonBundle\Query\PostgreSQL
 *
 * Extracted from http://pierrickcaen.fr/blog/symfony-sql-functions.html
 */

class StringAggFunction extends FunctionNode
{
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'string_agg(' . $this->expression->dispatch($sqlWalker) . ',' . $this->delimiter->dispatch($sqlWalker) .')';
    }

    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $parser->match(Lexer::T_DISTINCT);
        $this->expression = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_COMMA);
        $this->delimiter = $parser->ArithmeticPrimary();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}