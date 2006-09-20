<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** iscReflectionTypeFactory - Interface definition for a iscReflectionTypeFactory                  **
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

//***** iscReflectionTypeFactory *********************************************************
/**
 * @package    Reflection
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
interface iscReflectionTypeFactory {
    /**
     * Creates a type object for given typename
     * @param string $typename
     * @return iscReflectionType
     */
    function getType($typename);
}

?>