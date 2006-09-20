<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** iscReflectionClass - Reflection API extended with PHPDoc Infos        **
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

//***** iscReflectionClass **************************************************
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
class iscReflectionClass extends ReflectionClass {
    /**
    * @var iscReflectionDocParser
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
        $this->docParser = new iscReflectionDocParser($this->getDocComment());
        $this->docParser->parse();
    }

    //=======================================================================
    /**
    * @param string $name
    * @return iscReflectionMethod
    */
    public function getMethod($name) {
        return new iscReflectionMethod($this->getName(), $name);
    }

    //=======================================================================
    /**
    * @return iscReflectionMethod
    */
    public function getConstructor() {
        $con = parent::getConstructor();
        if ($con != null) {
            $extCon = new iscReflectionMethod($this->getName(), $con->getName());
            return $extCon;
        }
        else {
            return null;
        }
    }

    //=======================================================================
    /**
    * @return iscReflectionMethod[]
    */
    public function getMethods() {
        $extMethodes = array();
        $methodes = parent::getMethods();
        foreach ($methodes as $method) {
            $extMethodes[] = new iscReflectionMethod($this->getName(), $method->getName());
        }
        return $extMethodes;
    }

    //=======================================================================
    /**
    * @return iscReflectionClassType
    */
    public function getParentClass() {
        $class = parent::getParentClass();
        if (is_object($class)) {
            return new iscReflectionClassType($class->getName());
        }
        else {
            return null;
        }
    }

    //=======================================================================
    /**
    * @param string $name
    * @return iscReflectionProperty
    * @throws RelectionException if property doesn't exists
    */
    public function getProperty($name) {
        $pro = parent::getProperty($name);
        return new iscReflectionProperty($this->getName(), $name);
    }

    //=======================================================================
    /**
    * @return iscReflectionProperty[]
    */
    public function getProperties() {
        $props = parent::getProperties();
        $extProps = array();
        foreach ($props as $prop) {
            $extProps[] = new iscReflectionProperty($this->getName(),
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
    * @return iscReflectionExtension
    */
    public function getExtension() {
        $name = $this->getExtensionName();
        if (!empty($name)) {
            return new iscReflectionExtension($name);
        }
        else {
            return null;
        }
    }
}
?>