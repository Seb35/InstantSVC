<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ExtReflectionParameter - Reflection API extended with PHPDoc Infos    **
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

//***** ExtReflectionParameter **********************************************
/**
* Extends the reflection API using PHPDoc comments to provied
* type information
*
* @package    libs.reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2005 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class ExtReflectionParameter extends ReflectionParameter {
    /**
    * @var Type
    */
    protected $type;

    /**
    * @var ReflectionParameter
    */
    protected $parameter = null;

    //=======================================================================
    /**
    * @param mixed $mixed Type info or $function for parent class
    * @param mixed $parameter ReflectionParameter or $parameter for parent class
    * @param string $type Type information from param tag
    */
    public function __construct($mixed, $parameter) {
        if ($parameter instanceof ReflectionParameter) {
            $this->parameter = $parameter;
            $this->type = ExtendedReflectionApi::getInstance()->getTypeByName($mixed);
        }
        else {
            parent::__construct($mixed, $parameter);
        }

    }

    //=======================================================================
    /**
    * @return Type
    */
    public function getType() {
        return $this->type;
    }

    //***** Overriding methodes if nessecary ********************************

    //=======================================================================
    /**
    * @return bool
    */
    public function allowsNull() {
        if ($this->parameter != null) {
            return $this->parameter->allowsNull();
        }
        else {
            return parent::allowsNull();
        }
    }

    //=======================================================================
    /**
    * @return bool
    */
    public function isOptional() {
        if ($this->parameter != null) {
            return $this->parameter->isOptional();
        }
        else {
            return parent::isOptional();
        }
    }

    //=======================================================================
    /**
    * @return bool
    */
    public function isPassedByReference() {
        if ($this->parameter != null) {
            return $this->parameter->isPassedByReference();
        }
        else {
            return parent::isPassedByReference();
        }
    }

    //=======================================================================
    /**
    * @return bool
    */
    public function isDefaultValueAvailable() {
        if ($this->parameter != null) {
            return $this->parameter->isDefaultValueAvailable();
        }
        else {
            return parent::isDefaultValueAvailable();
        }
    }

    //=======================================================================
    /**
    * @return string
    */
    public function getName() {
        if ($this->parameter != null) {
            return $this->parameter->getName();
        }
        else {
            return parent::getName();
        }
    }

    //=======================================================================
    /**
    * @return mixed
    */
    public function getDefaultValue() {
        if ($this->parameter != null) {
            return $this->parameter->getDefaultValue();
        }
        else {
            return parent::getDefaultValue();
        }
    }

    //=======================================================================
    /**
    * Returns reflection object identified by php type hinting
    * @return ClassType
    */
    public function getClass() {
        if ($this->type && $this->type->isClass()) {
            return $this->type;
        }
        return null;
    }

    //=======================================================================
    /**
    * @return ExtReflectionFunction
    */
    public function getDeclaringFunction() {
        if ($this->parameter != null) {
            $func = $this->parameter->getDeclaringFunction();
        }
        else {
            $func = parent::getDeclaringFunction();
        }
        if (!empty($func)) {
            return new ExtReflectionFunction($func->getName());
        }
        else {
            return null;
        }
	}

    //=======================================================================
    /**
    * @return ClassType
    */
    function getDeclaringClass() {
        if ($this->parameter != null) {
            $class = $this->parameter->getDeclaringClass();
        }
        else {
            $class = parent::getDeclaringClass();
        }

		if (!empty($class)) {
		    return new ClassType($class->getName());
		}
		else {
		    return null;
		}
    }
}
?>
