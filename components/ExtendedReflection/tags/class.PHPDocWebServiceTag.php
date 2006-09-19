<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** PHPDocWebServiceTag                                                   **
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

//***** PHPDocWebServiceTag *************************************************
/**
* @package    reflection.tags
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2005 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class PHPDocWebServiceTag extends PHPDocTag {

    //=======================================================================
    /**
    * @param string[] $line Array of words
    */
    public function __construct($line) {
    	//$line[0] should be webservice, proof it?
        $this->tagName = $line[0];
    }
}
?>
