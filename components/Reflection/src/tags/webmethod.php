<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** iscReflectionDocTagWebMethod                                                    **
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

//***** iscReflectionDocTagWebMethod **************************************************
/**
* @todo enhance tag with additional parameters, maybe information to name it
*       in the wsdl file or what else may be usefull (have look at java and
*       .net annotations)
* @package    reflection.tags
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2005 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class iscReflectionDocTagWebMethod extends iscReflectionDocTag {

    //=======================================================================
    /**
    * @param string[] $line Array of words
    */
    public function __construct($line) {
    	//$line[0] should be webmethod, proof it?
        $this->tagName = $line[0];
    }
}
?>
