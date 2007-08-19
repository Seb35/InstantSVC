<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ezcReflectionExtension - Reflection API extended with PHPDoc Infos    **
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

//***** ezcReflectionExtension **********************************************
/**
* Extends the reflection API using PHPDoc comments to provied
* type information
*
* @package    Reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class ezcReflectionExtension extends ReflectionExtension {

    //=======================================================================
    /**
    * @param string $name
    */
    public function __construct($name) {
        parent::__construct($name);
    }

    //=======================================================================
    /**
    * @return ezcReflectionFunction[]
    */
    public function getFunctions() {
        $functs = parent::getFunctions();
        $result = array();
        foreach ($functs as $func) {
        	$function = new ezcReflectionFunction($func->getName());
        	$result[] = $function;
        }
        return $result;
    }

    //=======================================================================
    /**
     * @return ezcReflectionClassType[]
     */
    public function getClasses() {
        $classes = parent::getClasses();
        $result = array();
        foreach ($classes as $class) {
        	$extClass = new ezcReflectionClassType($class->getName());
        	$result[] = $extClass;
        }
        return $result;
    }
}
?>