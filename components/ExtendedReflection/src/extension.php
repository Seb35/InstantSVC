<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ExtReflectionExtension - Reflection API extended with PHPDoc Infos    **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    reflection                                                **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 ...                                                  **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** ExtReflectionExtension **********************************************
/**
* Extends the reflection API using PHPDoc comments to provied
* type information
*
* @package    libs.reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class ExtReflectionExtension extends ReflectionExtension {

    //=======================================================================
    /**
    * @param string $name
    */
    public function __construct($name) {
        parent::__construct($name);
    }

    //=======================================================================
    /**
    * @return ExtReflectionFunction[]
    */
    public function getFunctions() {
        $functs = parent::getFunctions();
        $result = array();
        foreach ($functs as $func) {
        	$function = new ExtReflectionFunction($func->getName());
        	$result[] = $function;
        }
        return $result;
    }

    //=======================================================================
    /**
     * @return ExtReflectionClass[]
     */
    public function getClasses() {
        $classes = parent::getClasses();
        $result = array();
        foreach ($classes as $class) {
        	$extClass = new ExtReflectionClass($class->getName());
        	$result[] = $extClass;
        }
        return $result;
    }
}
?>