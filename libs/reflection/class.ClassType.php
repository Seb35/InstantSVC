<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ClassType - representation for all class types                        **
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
require_once(dirname(__FILE__).'/class.ExtReflectionClass.php');
require_once(dirname(__FILE__).'/interface.Type.php');
require_once(dirname(__FILE__).'/const.xml.php');

//***** ClassType ***********************************************************
/**
 * @package    libs.reflection
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class ClassType extends ExtReflectionClass implements Type {

    //=======================================================================
    /**
     * @return Type
     */
    public function getArrayType() {
        return null;
    }

    //=======================================================================
    /**
     * @return Type
     */
    function getMapIndexType() {
        return null;
    }

    //=======================================================================
    /**
     * @return Type
     */
    function getMapValueType() {
        return null;
    }

    //=======================================================================
    /**
     * @return boolean
     */
    function isArray() {
        return false;
    }

    //=======================================================================
    /**
     * @return boolean
     */
    function isClass() {
        return true;
    }

    //=======================================================================
    /**
     * @return boolean
     */
    function isPrimitive() {
        return false;
    }

    //=======================================================================
    /**
     * @return boolean
     */
    function isMap() {
        return false;
    }

    //=======================================================================
    /**
     * @return string
     */
    function toString() {
        return $this->getName();
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
        return $this->getName();
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
     * Returns a <xsd:complexType/>
     * @param DOMDocument $dom
     * @return DOMElement
     */
    function getXmlSchema($dom) {
        $schema = $dom->createElementNS(XSD_SCHEMA, 'xsd:complexType');
        $schema->setAttribute('name', $this->getXmlName());


        $parent = $this->getParentClass();
        //if we have a parent class, we will include this infos in the xsd
        if ($parent != null) {
            $complex = $dom->createElementNS(XSD_SCHEMA, 'xsd:complexContent');
            $complex->setAttribute('mixed', 'false');
            $ext = $dom->createElementNS(XSD_SCHEMA, 'xsd:extension');
            $ext->setAttribute('base', XSD_TNSPREFIX.':'.$parent->getXmlName());
            $complex->appendChild($ext);
            $schema->appendChild($complex);
            $root = $ext;
        }
        else {
            $root = $schema;
        }

        $seq = $dom->createElementNS(XSD_SCHEMA, 'xsd:sequence');
        $root->appendChild($seq);
        $props = $this->getProperties();
        foreach ($props as $property) {
        	$type = $property->getType();
        	if ($type != null and !$type->isMap()) {
                $elm = $dom->createElementNS(XSD_SCHEMA, 'xsd:element');
            	$elm->setAttribute('minOccurs', '0');
            	$elm->setAttribute('maxOccurs', '1');
            	$elm->setAttribute('nillable', 'true');

            	$elm->setAttribute('name', $property->getName());

            	if ($type->isPrimitive()) {
            	    $elm->setAttribute('type', $type->getXmlName());
            	}
            	else {
            	    $elm->setAttribute('type', XSD_TNSPREFIX.':'.$type->getXmlName());
            	}
            	$seq->appendChild($elm);
        	}
        }
        return $schema;
    }

    /**
     * <xs:schema xmlns:tns="http://tele-task.de/model/" xmlns:ttm="http://tele-task.de/model/"
		   elementFormDefault="qualified" targetNamespace="http://tele-task.de/model/" xmlns:xs="http://www.w3.org/2001/XMLSchema">
  <xs:complexType name="Item" />

  <xs:complexType name="Lecture">
    <xs:complexContent mixed="false">
      <xs:extension base="tns:Item">
        <xs:sequence>
          <xs:element minOccurs="1" maxOccurs="1" name="id" type="xs:int" />
          <xs:element minOccurs="0" maxOccurs="1" name="name" type="xs:string" />
          <xs:element minOccurs="0" maxOccurs="1" name="duration" type="xs:int" />
          <xs:element minOccurs="0" maxOccurs="1" name="namehtml" type="xs:string" />
          <xs:element minOccurs="0" maxOccurs="1" name="streamurldsl" type="xs:string" />
          <xs:element minOccurs="0" maxOccurs="1" name="abstract" type="xs:string" />
          <xs:element minOccurs="0" maxOccurs="1" name="languagesId" type="xs:int" nillable="true" />

          <xs:element minOccurs="0" maxOccurs="1" name="logo" type="xs:int" nillable="true" />
          <xs:element minOccurs="0" maxOccurs="1" name="time" type="xs:int" nillable="true" />
          <xs:element minOccurs="0" maxOccurs="1" name="sortdate" type="xs:string" />
        </xs:sequence>
      </xs:extension>
    </xs:complexContent>
  </xs:complexType>
     */
}
?>