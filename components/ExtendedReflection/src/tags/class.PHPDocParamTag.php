<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** PHPDocParamTag                                                        **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    reflection                                                **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2005 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/../class.PHPDocTag.php');

//***** PHPDocParamTag ******************************************************
/**
* @package    reflection.tags
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2005 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class PHPDocParamTag extends PHPDocTag {

    //=======================================================================
    /**
    * @param string[] $line Array of words
    */
    public function __construct($line) {
        $this->tagName = $line[0];

        if (isset($line[1])) {
            $this->params[0] = TypeMapper::getInstance()->getType($line[1]);
        }
        if (isset($line[2]) and strlen($line[2])>0) {
            if ($line[2]{0} == '$') {
                $line[2] = substr($line[2], 1);
            }
            $this->params[1] = $line[2];
        }
        if (isset($line[3])) {
            $this->desc = $line[3];
        }
    }

    //=======================================================================
    /**
    * @return string
    */
    public function getParamName() {
        if (isset($this->params[1])) {
            return $this->params[1];
        }
        else {
            return null;
        }
    }

    //=======================================================================
    /**
    * @return string
    */
    public function getType() {
        return $this->params[0];
    }
}
?>
