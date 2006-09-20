<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** iscReflectionDocTagFactory - Creates a iscReflectionDocTag object be the given doctag     **
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

//***** iscReflectionDocTagFactory ****************************************************
/**
* Creates a iscReflectionDocTag object be the given doctag
*
* @package    Reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 Stefan Marr
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class iscReflectionDocTagFactory {

    //=======================================================================
    /**
    * @param string $type
    * @param string[] $line Array of words
    * @return iscReflectionDocTag
    */
    static public function createTag($type, $line) {
        $tagClassName = 'PHPDoc'.$type.'Tag';
        $tag = null;
        if (class_exists($tagClassName)) {
            $tag = new $tagClassName($line);
        }
        else {
            $tag = new iscReflectionDocTag($line);
        }
        return $tag;
    }
}
?>
