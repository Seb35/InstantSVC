<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ezcReflectionClass - Reflection API extended with PHPDoc Infos        **
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

//***** ezcReflectionClass **************************************************
/**
* Extends the reflection API using PHPDoc comments to provied
* type information
*
* @package    Reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @author     Falko Menge <mail@falko-menge.de>
* @copyright  2005-2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class ezcReflectionClass extends ReflectionClass {
    /**
    * @var ezcReflectionDocParser
    */
    protected $docParser;

    //=======================================================================
    /**
    * @param string $name
    */
    public function __construct($name) {
        try {
            parent::__construct($name);
        }
        catch (Exception $e) {
            return;
        }
        $this->docParser = new ezcReflectionDocParser($this->getDocComment());
        $this->docParser->parse();
    }

    //=======================================================================
    /**
    * @param string $name
    * @return ezcReflectionMethod
    */
    public function getMethod($name) {
        return new ezcReflectionMethod($this->getName(), $name);
    }

    //=======================================================================
    /**
    * @return ezcReflectionMethod
    */
    public function getConstructor() {
        $con = parent::getConstructor();
        if ($con != null) {
            $extCon = new ezcReflectionMethod($this->getName(), $con->getName());
            return $extCon;
        }
        else {
            return null;
        }
    }

    //=======================================================================
    /**
    * @return ezcReflectionMethod[]
    */
    public function getMethods() {
        $extMethodes = array();
        $methodes = parent::getMethods();
        foreach ($methodes as $method) {
            $extMethodes[] = new ezcReflectionMethod($this->getName(), $method->getName());
        }
        return $extMethodes;
    }

    //=======================================================================
    /**
    * @return ezcReflectionClassType
    */
    public function getParentClass() {
        $class = parent::getParentClass();
        if (is_object($class)) {
            return new ezcReflectionClassType($class->getName());
        }
        else {
            return null;
        }
    }

    //=======================================================================
    /**
    * @param string $name
    * @return ezcReflectionProperty
    * @throws RelectionException if property doesn't exists
    */
    public function getProperty($name) {
        $pro = parent::getProperty($name);
        return new ezcReflectionProperty($this->getName(), $name);
    }

    //=======================================================================
    /**
    * @return ezcReflectionProperty[]
    */
    public function getProperties() {
        $props = parent::getProperties();
        $extProps = array();
        foreach ($props as $prop) {
            $extProps[] = new ezcReflectionProperty($this->getName(),
                                                    $prop->getName());
        }
        return $extProps;
    }

    //=======================================================================
    /**
    * Check whether this class has been tagged with @webservice
    * @return boolean
    */
    public function isWebService() {
        return $this->docParser->isTagged("webservice");
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
    * @return ezcReflectionDocTag[]
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
    * @return ezcReflectionExtension
    */
    public function getExtension() {
        $name = $this->getExtensionName();
        if (!empty($name)) {
            return new ezcReflectionExtension($name);
        }
        else {
            return null;
        }
    }
}
?>