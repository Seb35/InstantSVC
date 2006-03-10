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
//** @copyright  2006 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/class.AbstractType.php');
require_once(dirname(__FILE__).'/const.xml.php');

//***** ArrayType ***********************************************************
/**
* Provides type information of the array item type or map types
*
* @package    libs.reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
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
     * @return string
     */
    function getXmlName() {
        if ($this->isArray()) {
            return 'ArrayOf'.$this->arrayType->getXmlName();
        }
        elseif ($this->isMap()) {
            throw new Exception('Xml mapping is not supported for map-types');
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
    function getXmlSchema($dom) {
        if ($this->isMap()) {
            throw new Exception('Xml mapping is not supported for map-types');
        }

        if (!$this->isArray()) {
            return null;
        }

        $schema = $dom->createElementNS(XSD_SCHEMA, 'xsd:complexType');
        $schema->setAttribute('name', $this->getXmlName());

        $seq = $dom->createElementNS(XSD_SCHEMA, 'xsd:sequence');
        $schema->appendChild($seq);
        $elm = $dom->createElementNS(XSD_SCHEMA, 'xsd:element');
        $seq->appendChild($elm);

        $elm->setAttribute('minOccurs', '0');
    	$elm->setAttribute('maxOccurs', '1');
    	$elm->setAttribute('nillable', 'true');

    	$elm->setAttribute('name', $this->arrayType->getXmlName());

    	if ($this->arrayType->isPrimitive()) {
    	    $elm->setAttribute('type', $this->arrayType->getXmlName());
    	}
    	else {
    	    $elm->setAttribute('type', XSD_TNSPREFIX.':'
    	                               .$this->arrayType->getXmlName());
    	}

        return $schema;
    }
}

?>