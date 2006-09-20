<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** iscReflectionAbstractType - Abstract class provides default implementation         **
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

//***** iscReflectionAbstractType ********************************************************
/**
* Provides default implementation and default null or false return falues
*
* @package    Reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
abstract class iscReflectionAbstractType implements iscReflectionType {

    //=======================================================================
    /**
     * Returns type of array items or null
     * @return iscReflectionType
     */
    public function getiscReflectionArrayType() {
        return null;
    }

    //=======================================================================
    /**
     * Returns key type of map items or null
     * @return iscReflectionType
     */
    public function getMapIndexType() {
        return null;
    }

    //=======================================================================
    /**
     * Returns value type of map items or null
     * @return iscReflectionType
     */
    public function getMapValueType() {
        return null;
    }

    //=======================================================================
    /**
     * @return boolean
     */
    public function isArray() {
        return false;
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
        return false;
    }
}

?>