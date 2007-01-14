<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Foo - TestClass                                                       **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    WSDLGenerator                                             **
//** @author     Falko Menge <mail@falko-menge.de>                         **
//** @author     Gregor Gabrysiak <gregor_abrak at web dot de>             **
//** @copyright  2006 ...                                                  **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

/**
 * @package    libs.generator
 * @author     Falko Menge <mail@falko-menge.de>
 * @author     Gregor Gabrysiak <gregor_abrak at web dot de>
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @webserializable
 */
class Foo {

    /**
     * @var string $inputString
     */
    public $inputString = 'test';
    /**
     * @var int $myInteger
     */
    public $myInteger = 20;
    /**
     * @var string[] $stringarray
     */
    public $stringArray = array('1d2','a1d');
    /**
     * @var double $myDouble
     */
    public $myDouble;
    
}
?>