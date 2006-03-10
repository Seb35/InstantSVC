<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** PrimitiveType - representation for all primitive types like string,   **
//**                 integer, float aso.                                   **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    libs.reflection                                           **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/class.AbstractType.php');

//***** PrimitiveType *******************************************************
/**
 * @package    libs.reflection
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class PrimitiveType extends AbstractType {

    /**
     * @var string
     */
    private $typeName;

    //=======================================================================
    /**
     * @param string $typeName
     */
    public function __construct($typeName) {
        $this->typeName = $typeName;
    }

    //=======================================================================
    /**
     * @return boolean
     */
    public function isPrimitive() {
        return true;
    }

    //=======================================================================
    /**
     * @return string
     */
    public function toString() {
        return $this->typeName;
    }

    //=======================================================================
    /**
     * @return boolean
     */
    function isStandardType() {
        if ($this->typeName != 'mixed' and $this->typeName != 'void') {
            return true;
        }
        return false;
    }

    //=======================================================================
    /**
     * @return string
     */
    function getXmlName() {
        return TypeMapper::getInstance()->getXmlType($this->typeName);
    }

    //=======================================================================
    /**
     * @return string
     */
    function getNamespace() {
        return '';
    }

    //=======================================================================
    /**
     * @param DOMDocument
     * @return DOMElement
     */
    function getXmlSchema($dom) {
        return null;
    }
}

?>