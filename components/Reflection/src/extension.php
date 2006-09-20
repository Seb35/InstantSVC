<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** iscReflectionExtension - Reflection API extended with PHPDoc Infos    **
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

//***** iscReflectionExtension **********************************************
/**
* Extends the reflection API using PHPDoc comments to provied
* type information
*
* @package    Reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class iscReflectionExtension extends ReflectionExtension {

    //=======================================================================
    /**
    * @param string $name
    */
    public function __construct($name) {
        parent::__construct($name);
    }

    //=======================================================================
    /**
    * @return iscReflectionFunction[]
    */
    public function getFunctions() {
        $functs = parent::getFunctions();
        $result = array();
        foreach ($functs as $func) {
        	$function = new iscReflectionFunction($func->getName());
        	$result[] = $function;
        }
        return $result;
    }

    //=======================================================================
    /**
     * @return iscReflectionClassType[]
     */
    public function getClasses() {
        $classes = parent::getClasses();
        $result = array();
        foreach ($classes as $class) {
        	$extClass = new iscReflectionClassType($class->getName());
        	$result[] = $extClass;
        }
        return $result;
    }
}
?>