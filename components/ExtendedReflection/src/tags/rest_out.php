<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** PHPDocRestOutTag                                                      **
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

//***** PHPDocRestOutTag ****************************************************
/**
* @package    reflection.tags
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class PHPDocRestOutTag extends PHPDocTag {

    /**
     * @var string
     */
    private $serializerClass;

    //=======================================================================
    /**
    * @param string[] $line Array of words
    */
    public function __construct($line) {
        $this->tagName = $line[0];
        if (isset($line[1])) {
            $this->serializerClass = $line[1];
        }
    }

    //=======================================================================
    /**
     * @return string
     */
    public function getSerializer() {
        return $this->serializerClass;
    }
}
?>