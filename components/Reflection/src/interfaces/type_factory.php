<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ezcReflectionTypeFactory - Interface definition for a ezcReflectionTypeFactory                  **
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

//***** ezcReflectionTypeFactory *********************************************************
/**
 * @package    Reflection
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
interface ezcReflectionTypeFactory {
    /**
     * Creates a type object for given typename
     * @param string $typename
     * @return ezcReflectionType
     */
    function getType($typename);
}

?>