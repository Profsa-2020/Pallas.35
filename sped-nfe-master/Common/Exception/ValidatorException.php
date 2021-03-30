<?php

namespace NFePHP\Common\Exception;

/**
 * @category   NFePHP
 * @package    NFePHP\Common\Exception
 * @copyright  Copyright (c) 2008-2017
 * @license    http://www.gnu.org/licenses/lesser.html LGPL v3
 * @author     Roberto L. Machado <linux.rlm at gmail dot com>
 * @link       http://github.com/nfephp-org/sped-common for the canonical source repository
 */

class ValidatorException extends \RuntimeException implements ExceptionInterface
{
    public static function xmlErrors(array $errors)
    {
        $msg = '';
        foreach ($errors as $error) {
            $msg .= $error . '<br/><br/>';
        }
        return new static('Formato e Dados do XML não é válido: <br/>' . $msg);
    }
    
    public static function isNotXml()
    {
        return new static('Esta string com XML não tem formato válido');
    }
}
