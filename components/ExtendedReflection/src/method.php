<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ExtReflectionMethod - Reflection API extended with PHPDoc Infos       **
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

//***** ExtReflectionMethod *************************************************
/**
* Extends the reflection API using PHPDoc comments to provied
* type information
*
* @package    libs.reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2005-2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class ExtReflectionMethod extends ReflectionMethod {
    /**
    * @var PHPDocParser
    */
    protected $docParser;

    //=======================================================================
    /**
    * @param mixed $class
    * @param string $name
    */
    public function __construct($class, $name) {
        parent::__construct($class, $name);
        $this->docParser = new PHPDocParser($this->getDocComment());
        $this->docParser->parse();
    }

    //=======================================================================
    /**
    * @return ExtReflectionParameter[]
    */
    function getParameters() {
        $params = $this->docParser->getParamTags();
        $extParams = array();
        $apiParams = parent::getParameters();
        foreach ($apiParams as $param) {
            $found = false;
            foreach ($params as $tag) {
            	if ($tag->getParamName() == $param->getName()) {
            	   $extParams[] = new ExtReflectionParameter($tag->getType(),
            	                                             $param);
            	   $found = true;
            	   break;
            	}
            }
            if (!$found) {
                $extParams[] = new ExtReflectionParameter(null, $param);
            }
        }
        return $extParams;
    }

    //=======================================================================
    /**
    * Returns the type definied in PHPDoc tags
    * @return Type
    */
    function getReturnType() {
        $re = $this->docParser->getReturnTags();
        if (count($re) == 1 and isset($re[0])) {
            return ExtendedReflectionApi::getInstance()->getTypeByName($re[0]->getType());
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
    * @return PHPDocTag[]
    */
    public function getTags($name = '') {
        if ($name = '') {
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
     * @return ClassType
     */
    function getDeclaringClass() {
        $class = parent::getDeclaringClass();
		if (!empty($class)) {
		    return new ClassType($class->getName());
		}
		else {
		    return null;
		}
    }
}
?>
