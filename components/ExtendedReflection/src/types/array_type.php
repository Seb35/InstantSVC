<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ArrayType - Provide infos for array tyes                              **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    reflection                                                **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @author     Falko Menge <mail@falko-menge.de>                         **
//** @copyright  2006 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** ArrayType ***********************************************************
/**
 * Provides type information of the array item type or map types
 *
 * @package    libs.reflection
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @author     Falko Menge <mail@falko-menge.de>
 * @copyright  2006 ....
 * @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
 * @todo       add support for ArrayAccess stuff from http://www.php.net/~helly/php/ext/spl/
 */
class ArrayType extends AbstractType {

    /**
     * @var string
     */
    private $typeName = null;

    /**
     * @var Type
     */
    private $arrayType = null;

    /**
     * @var Type
     */
    private $mapKeyType = null;

    /**
     * @var Type
     */
    private $mapValueType = null;

    //=======================================================================
    /**
     * @param string $typeName
     */
    public function __construct($typeName) {
        $this->typeName = $typeName;
        $this->_parseTypeName();
    }

    //=======================================================================
    /**
     * Returns type of array items or null
     * @return Type
     */
    public function getArrayType() {
        return $this->arrayType;
    }

    //=======================================================================
    /**
     * Returns key type of map items or null
     * @return Type
     */
    public function getMapIndexType() {
        return $this->mapKeyType;
    }

    //=======================================================================
    /**
     * Returns key type of map items or null
     * @return Type
     */
    public function getMapValueType() {
        return $this->mapValueType;
    }

    //=======================================================================
    /**
     * @return boolean
     */
    public function isArray() {
        return ($this->arrayType != null);
    }

    //=======================================================================
    /**
     * @return boolean
     */
    public function isClass() {
        return false;
    }

    //=======================================================================
    /**
     * @return boolean
     */
    public function isPrimitive() {
        return false;
    }

    //=======================================================================
    /**
     * @return boolean
     */
    public function isMap() {
        return ($this->mapKeyType != null);
    }

    //=======================================================================
    protected function _parseTypeName() {
        $seamsToBeMap = false;
        $pos = strrpos($this->typeName, '[');
        //there seams to be an array
        if ($pos !== false) {
            //proof there is no array map tag around
            $posm = strrpos($this->typeName, '>');
            if ($posm !== false) {
                if ($posm < $pos) {
                    $typeName = substr($this->typeName, 0, $pos);
                    $this->arrayType
                       = ExtendedReflectionApi::getInstance()->getTypeByName($typeName);
                }
            }
            else {
                $typeName = substr($this->typeName, 0, $pos);
                $this->arrayType
                   = ExtendedReflectionApi::getInstance()->getTypeByName($typeName);
            }
        }
        if (preg_match('/(.*)(<(.*?)(,(.*?))?>)/', $this->typeName, $matches)) {
            $type1 = null;
            $type2 = null;
            if (isset($matches[3])) {
                $type1 = ExtendedReflectionApi::getInstance()->getTypeByName($matches[3]);
            }
            if (isset($matches[5])) {
                $type2 = ExtendedReflectionApi::getInstance()->getTypeByName($matches[3]);
            }

            if ($type1 == null and $type2 != null) {
                $this->arrayType = $type2;
            }
            elseif ($type1 != null and $type2 == null) {
                $this->arrayType = $type1;
            }
            elseif ($type1 != null and $type2 != null) {
                $this->mapKeyType = $type1;
                $this->mapValueType = $type2;
            }
        }
    }

    //=======================================================================
    /**
     * @return string
     */
    public function toString() {
        if ($this->isArray()) {
            return $this->arrayType->toString().'[]';
        }
        else if ($this->isMap()) {
            return 'array<'.$this->mapKeyType->toString()
                        .','.$this->mapValueType->toString().'>';
        }
        return null;
    }

    //=======================================================================
    /**
     * @return boolean
     */
    function isStandardType() {
        return false;
    }

    //=======================================================================
    /**
     * Returns XML Schema name of the complexType for the array
     *
     * The `this namespace' (tns) prefix is comonly used to refer to the
     * current XML Schema document.
     *
     * @param boolean $usePrefix augments common prefix `tns:' to the name
     * @return string
     */
    function getXmlName($usePrefix = true) {
        if ($usePrefix) {
            $prefix = 'tns:';
        } else {
            $prefix = '';
        }
        if ($this->isArray()) {
            return $prefix . 'ArrayOf'.$this->arrayType->getXmlName(false);
        }
        elseif ($this->isMap()) {
            throw new Exception('XML Schema mapping is not supported for map-types');
        }
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
     * Returns an <xsd:complexType/>
     *
     * @example
     *   <xs:complexType name="ArrayOfLecture">
     *     <xs:sequence>
     *        <xs:element minOccurs="0" maxOccurs="unbounded"
     *                    name="Lecture" nillable="true" type="tns:Lecture" />
     *     </xs:sequence>
     *   </xs:complexType>
     *
     * @param DOMDocument $dom
     * @return DOMElement
     */
    function getXmlSchema($dom, $namespaceXMLSchema = 'http://www.w3.org/2001/XMLSchema') {
        if ($this->isMap()) {
            throw new Exception('XML Schema mapping is not supported for map-types');
        }

        if (!$this->isArray()) {
            return null;
        }

        $schema = $dom->createElementNS($namespaceXMLSchema, 'xsd:complexType');
        $schema->setAttribute('name', $this->getXmlName(false));

        $seq = $dom->createElementNS($namespaceXMLSchema, 'xsd:sequence');
        $schema->appendChild($seq);
        $elm = $dom->createElementNS($namespaceXMLSchema, 'xsd:element');
        $seq->appendChild($elm);

        $elm->setAttribute('minOccurs', '0');
        $elm->setAttribute('maxOccurs', 'unbounded');
        $elm->setAttribute('nillable', 'true');

        $elm->setAttribute('name', $this->arrayType->getXmlName(false));
        $elm->setAttribute('type', $this->arrayType->getXmlName(true));

        return $schema;
    }
}

?>