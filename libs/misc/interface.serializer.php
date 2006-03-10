<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Serializer - this interface combines serializer and deserializer      **
//**              to be used in a symetric way                             **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    libs.misc                                                 **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** Serializer **********************************************************
/**
 * @package    libs.misc
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
interface Serializer {

    /**
     * Convert given data into a string representation
     * @param mixed $data
     * @return string
     */
    public function serialize($data);

    /**
     * Extracts data from a string and returns it as php data structure
     * @param string $str
     * @return mixed
     */
    public function deserialize($str);
}

?>