<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ezcReflectionProperty - Reflection API extended with PHPDoc Infos     **
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

//***** ezcReflectionProperty ***********************************************
/**
* Extends the reflection API using PHPDoc comments to provied
* type information
*
* @package    Reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2005 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class ezcReflectionProperty extends ReflectionProperty {
    /**
    * @var ezcReflectionDocParser
    */
    protected $docParser = null;

    //=======================================================================
    /**
    * @param mixed $class
    * @param string $name
    */
    public function __construct($class, $name) {
        parent::__construct($class, $name);

        if (method_exists($this, 'getDocComment')) {
            $this->docParser = new ezcReflectionDocParser($this->getDocComment());
            $this->docParser->parse();
        }
    }

    //=======================================================================
    /**
    * @return ezcReflectionType
    */
    public function getType() {
        if ($this->docParser == null) {
            return 'unknown(ReflectionProperty::getDocComment introduced at'.
                   ' first in PHP5.1)';
        }

        $vars = $this->docParser->getVarTags();
        if (isset($vars[0])) {
            return ezcReflectionApi::getInstance()->getTypeByName($vars[0]->getType());
        }
        else {
            return null;
        }
    }

    //=======================================================================
    /**
    * @return ezcReflectionClassType
    */
    public function getDeclaringClass() {
        $class = parent::getDeclaringClass();
        return new ezcReflectionClassType($class->getName());
    }
}
?>
