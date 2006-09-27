<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** iscReflectionMethod - Reflection API extended with PHPDoc Infos       **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    reflection                                                **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @author     Falko Menge <mail@falko-menge.de>                         **
//** @copyright  2005-2006 ...                                             **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** iscReflectionMethod *************************************************
/**
* Extends the reflection API using PHPDoc comments to provied
* type information
*
* @package    Reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2005-2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class iscReflectionMethod extends ReflectionMethod {
    /**
    * @var iscReflectionDocParser
    */
    protected $docParser;

    //=======================================================================
    /**
    * @param mixed $class
    * @param string $name
    */
    public function __construct($class, $name) {
        parent::__construct($class, $name);
        $this->docParser = new iscReflectionDocParser($this->getDocComment());
        $this->docParser->parse();
    }

    //=======================================================================
    /**
    * @return iscReflectionParameter[]
    */
    function getParameters() {
        $params = $this->docParser->getParamTags();
        $extParams = array();
        $apiParams = parent::getParameters();
        foreach ($apiParams as $param) {
            $found = false;
            foreach ($params as $tag) {
            	if ($tag->getParamName() == $param->getName()) {
            	   $extParams[] = new iscReflectionParameter($tag->getType(),
            	                                             $param);
            	   $found = true;
            	   break;
            	}
            }
            if (!$found) {
                $extParams[] = new iscReflectionParameter(null, $param);
            }
        }
        return $extParams;
    }

    //=======================================================================
    /**
    * Returns the type definied in PHPDoc tags
    * @return iscReflectionType
    */
    function getReturnType() {
        $re = $this->docParser->getReturnTags();
        if (count($re) == 1 and isset($re[0])) {
            return iscReflectionApi::getInstance()->getTypeByName($re[0]->getType());
        }
        return null;
    }

    //=======================================================================
    /**
    * Returns the description after a PHPDoc tag
    * @return string
    */
    function getReturnDescription() {
        $re = $this->docParser->getReturnTags();
        if (count($re) == 1 and isset($re[0])) {
            return $re[0]->getDescription();
        }
        return '';
    }

    //=======================================================================
    /**
    * Check whether this method has a @webmethod tag
    * @return boolean
    */
    function isWebmethod() {
        return $this->docParser->isTagged("webmethod");
    }

    //=======================================================================
    /**
    * @return string
    */
    public function getShortDescription() {
        return $this->docParser->getShortDescription();
    }

    //=======================================================================
    /**
    * @return string
    */
    public function getLongDescription() {
        return $this->docParser->getLongDescription();
    }

    //=======================================================================
    /**
    * @param string $with
    * @return boolean
    */
    public function isTagged($with) {
        return $this->docParser->isTagged($with);
    }

    //=======================================================================
    /**
    * @param string $name
    * @return iscReflectionDocTag[]
    */
    public function getTags($name = '') {
        if ($name == '') {
            return $this->docParser->getTags();
        }
        else {
            return $this->docParser->getTagsByName($name);
        }
    }

    //=======================================================================
    /**
     * Checks if this method is a 'Magic Method' or not
     * @return boolean
     */
    function isMagic() {
        $magicArray =  array('__construct','__destruct','__call','__get','__set','__isset','__unset','__sleep','__wakeup','__toString','__clone');
        return in_array($this->getName(),$magicArray);
    }

    //=======================================================================
    /**
     * Checks if this is already available in the parent class
     *
     * @param ReflectionClass
     * @return boolean
     */
    function isInherited($class) {
        $decClass = $this->getDeclaringClass();
        if ($class != null and $class instanceof ReflectionClass) {
            if ($decClass->getName() == $class->getName()) {
                $parent = $class->getParentClass();
                if (!empty($parent)) {
                    return $parent->hasMethod($this->getName());
                }
            }
            else {
                //if class is set right, this has to be a inherited method
                //not overriden in this class
                return true;
            }
        }

        return false;
    }

    //=======================================================================
    /**
     * Checks if this method is redefined in this class
     *
     * @param ReflectionClass
     * @return boolean
     */
    function isOverridden($class) {
        $decClass = $this->getDeclaringClass();
        if ($class != null and $class instanceof ReflectionClass) {
            return ($this->isInherited($class) and
                    $class->getName() == $decClass->getName());
        }
        return false;
    }

    //=======================================================================
    /**
     * @return iscReflectionClassType
     */
    function getDeclaringClass() {
        $class = parent::getDeclaringClass();
		if (!empty($class)) {
		    return new iscReflectionClassType($class->getName());
		}
		else {
		    return null;
		}
    }
}
?>
