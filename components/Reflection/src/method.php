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

    /**
     * This is the class for which this method object has been instantiated.
     * It is necessary to decide if a method is definied, inherited, overridden
     * in a class.
     *
     * @var ReflectionClass
     */
    protected $curClass;

    //=======================================================================
    /**
    * @param mixed $class
    * @param string $name
    */
    public function __construct($class, $name) {
        parent::__construct($class, $name);
        $this->docParser = new iscReflectionDocParser($this->getDocComment());
        $this->docParser->parse();
        if ($class instanceof ReflectionClass) {
            $this->curClass = $class;
        }
        elseif (is_string($class)) {
            $this->curClass = new ReflectionClass($class);
        }
        else {
            $this->curClass = null;
        }
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
     * @return boolean
     */
    function isInherited() {
        $decClass = $this->getDeclaringClass();
        if (!empty($this->curClass) and !empty($decClass)) {
            return ($decClass->getName() != $this->curClass->getName());
        }

        return false;
    }

    //=======================================================================
    /**
     * Checks if this method is redefined in this class
     * @return boolean
     */
    function isOverridden() {
        $decClass = $this->getDeclaringClass();
        if (!empty($this->curClass) and !empty($decClass)) {
            $parent = $this->curClass->getParentClass();
            if (!is_object($parent)) {
                return false;
            }
            else {
                return ($parent->hasMethod($this->getName()) and
                        $this->curClass->getName() == $decClass->getName());
            }
        }
        return false;
    }

    //=======================================================================
    /**
     * Checks if this method is appeared first in the current class
     * @return boolean
     */
    function isIntroduced() {
        return !$this->isInherited() and !$this->isOverridden();
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