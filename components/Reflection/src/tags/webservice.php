<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ezcReflectionDocTagWebService                                                   **
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

//***** ezcReflectionDocTagWebService *************************************************
/**
* @package    reflection.tags
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2005 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class ezcReflectionDocTagWebService extends ezcReflectionDocTag {

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
