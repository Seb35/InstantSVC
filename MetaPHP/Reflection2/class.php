<?php
require_once(dirname(__FILE__) . '/method.php');

/**
 * File containing the ezcReflectionClass class.
 *
 * @package Reflection
 * @version //autogentag//
 * @copyright Copyright (C) 2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Extends the ReflectionClass using PHPDoc comments to provide
 * type information
 * 
 * @package Reflection
 * @version //autogentag//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class iscReflectionClass extends ezcReflectionClass
{
    /**
    * @param string $name
    * @return ezcReflectionMethod
    */
    public function getMethod($name) {
    	return iscReflectionTypeFactoryImpl::getMethodObject($this, $name);
    }

    /**
    * @return ezcReflectionMethod
    */
    public function getConstructor() {
        $con = parent::getConstructor();
        if ($con != null) {
            $extCon = iscReflectionTypeFactoryImpl::getMethodObject($this, $con->getName());
            return $extCon;
        }
        else {
            return null;
        }
    }

    /**
    * @return ezcReflectionMethod[]
    */
    public function getMethods() {
        $extMethodes = array();
        $methodes = parent::getMethods();
        foreach ($methodes as $method) {
            $extMethodes[] = iscReflectionTypeFactoryImpl::getMethodObject($this, $method->getName());
        }
        return $extMethodes;
    }

    /**
    * @return ezcReflectionClassType
    */
    public function getParentClass() {
        $class = parent::getParentClass();
        if (is_object($class)) {
            return new iscReflectionClass($class->getName());
        }
        else {
            return null;
        }
    }
}
?>