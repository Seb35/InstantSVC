<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** PHPDocTagFactory - Creates a PHPDocTag object be the given doctag     **
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
//require_once(dirname(__FILE__).'/class.PHPDocTag.php');

//***** PHPDocTagFactory ****************************************************
/**
* Creates a PHPDocTag object be the given doctag
*
* @package    libs.reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 Stefan Marr
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class PHPDocTagFactory {

    //=======================================================================
    /**
    * @param string $type
    * @param string[] $line Array of words
    * @return PHPDocTag
    */
    static public function createTag($type, $line) {
        $tagClassName = 'PHPDoc'.$type.'Tag';
        $tag = null;
        if (class_exists($tagClassName)) {
            $tag = new $tagClassName($line);
        }
        else {
            $tag = new PHPDocTag($line);
        }
        return $tag;
    }
}
?>
