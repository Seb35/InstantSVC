<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ExtReflectionClass - Reflection API extended with PHPDoc Infos        **
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

//***** imports *************************************************************
//require_once(dirname(__FILE__).'/class.PHPDocParser.php');
//require_once(dirname(__FILE__).'/class.ClassType.php');
//require_once(dirname(__FILE__).'/class.ExtReflectionMethod.php');
//require_once(dirname(__FILE__).'/class.ExtReflectionProperty.php');

//***** ExtReflectionClass **************************************************
/**
* Extends the reflection API using PHPDoc comments to provied
* type information
*
* @package    libs.reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @author     Falko Menge <mail@falko-menge.de>
* @copyright  2005-2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class ExtReflectionClass extends ReflectionClass {
    /**
    * @var PHPDocParser
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
        $this->docParser = new PHPDocParser($this->getDocComment());
        $this->docParser->parse();
    }

    //=======================================================================
    /**
    * @param string $name
    * @return ExtReflectionMethod
    */
    public function getMethod($name) {
        return new ExtReflectionMethod($this->getName(), $name);
    }

    //=======================================================================
    /**
    * @return ExtReflectionMethod
    */
    public function getConstructor() {
        $con = parent::getConstructor();
        $extCon = new ExtReflectionMethod($this->getName(), $con->getName());
        return $extCon;
    }

    //=======================================================================
    /**
    * @return ExtReflectionMethod[]
    */
    public function getMethods() {
        $extMethodes = array();
        $methodes = parent::getMethods();
        foreach ($methodes as $method) {
            $extMethodes[] = new ExtReflectionMethod($this->getName(), $method->getName());
        }
        return $extMethodes;
    }

    //=======================================================================
    /**
    * @return ClassType
    */
    public function getParentClass() {
        $class = parent::getParentClass();
        if (is_object($class)) {
            return new ClassType($class->getName());
        }
        else {
            return null;
        }
    }

    //=======================================================================
    /**
    * @param string $name
    * @return ExtReflectionProperty
    */
    public function getProperty($name) {
        $pro = parent::getProperty($name);
        return new ExtReflectionProperty($this->getName(), $name);
    }

    //=======================================================================
    /**
    * @return ExtReflectionProperty[]
    */
    public function getProperties() {
        $props = parent::getProperties();
        $extProps = array();
        foreach ($props as $prop) {
            $extProps[] = new ExtReflectionProperty($this->getName(),
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
    * @return PHPDocTag[]
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
    * @return ExtReflectionExtension
    */
    public function getExtension() {
        $name = $this->getExtensionName();
        if (!empty($name)) {
            return new ExtReflectionExtension($name);
        }
        else {
            return null;
        }
    }
}
?>