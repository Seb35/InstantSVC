<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Type - Interface for type objects representing a type                 **
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

//***** Type ****************************************************************
/**
* Interface for type objects representing a type
*
* @package    libs.reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
interface Type {
    /**
     * Return type of elements in an array type or null if is not an array
     * @return Type
     */
    function getArrayType();

    /**
     * Returns type of key used in a map
     * @return Type
     */
    function getMapIndexType();

    /**
     * Returns type of values used in a map
     * @return Type
     */
    function getMapValueType();

    /**
     * @return boolean
     */
    function isArray();

    /**
     * @return boolean
     */
    function isClass();

    /**
     * @return boolean
     */
    function isPrimitive();

    /**
     * @return boolean
     */
    function isMap();

    /**
     * Return the name of this type as string
     * @return string
     * @todo aprove name, may be getName is better
     */
    function toString();

    //** Advanced infos for xml mapping ************************************
    /**
     * @return boolean
     */
    function isStandardType();

    /**
     * Returns the name to be used in a xml schema for this type
     * @return string
     */
    function getXmlName();

    /**
     * @param DOMDocument $dom
     * @return DOMElement
     */
    function getXmlSchema($dom);
}
?>