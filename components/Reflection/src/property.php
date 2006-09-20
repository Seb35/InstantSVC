<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ExtReflectionProperty - Reflection API extended with PHPDoc Infos     **
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

//***** ExtReflectionProperty ***********************************************
/**
* Extends the reflection API using PHPDoc comments to provied
* type information
*
* @package    libs.reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2005 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class ExtReflectionProperty extends ReflectionProperty {
    /**
    * @var PHPDocParser
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
            $this->docParser = new PHPDocParser($this->getDocComment());
            $this->docParser->parse();
        }
    }

    //=======================================================================
    /**
    * @return Type
    */
    public function getType() {
        if ($this->docParser == null) {
            return 'unknown(ReflectionProperty::getDocComment introduced at'.
                   ' first in PHP5.1)';
        }

        $vars = $this->docParser->getVarTags();
        if (isset($vars[0])) {
            return ExtendedReflectionApi::getInstance()->getTypeByName($vars[0]->getType());
        }
        else {
            return null;
        }
    }

    //=======================================================================
    /**
    * @return ClassType
    */
    public function getDeclaringClass() {
        $class = parent::getDeclaringClass();
        return new ClassType($class->getName());
    }
}
?>
