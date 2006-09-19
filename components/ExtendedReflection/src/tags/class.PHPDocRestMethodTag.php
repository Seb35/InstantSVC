<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** PHPDocRestMethodTag                                                   **
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

//***** PHPDocRestMethodTag *************************************************
/**
* @package    reflection.tags
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2005 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class PHPDocRestMethodTag extends PHPDocTag {

    /**
     * @var string
     */
    private $httpMethod = '';

    /**
     * @var string
     */
    private $pattern = '';

    //=======================================================================
    /**
    * @param string[] $line Array of words
    */
    public function __construct($line) {
    	//$line[0] should be webmethod, proof it?
        $this->tagName = $line[0];
        if (isset($line[1])) {
            $this->httpMethod = $line[1];
        }
        if (isset($line[2])) {
            $this->pattern = $line[2];
        }
    }

    //=======================================================================
    /**
     * @return string
     */
    public function getHttpMethod() {
        return $this->httpMethod;
    }

    //=======================================================================
    /**
     * @return string
     */
    public function getRequestPattern() {
        return $this->pattern;
    }
}
?>