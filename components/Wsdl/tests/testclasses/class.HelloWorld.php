<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Hello World - TestClass                                               **
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

//***** HelloWorld **********************************************************
/**
 * @package    libs.generator
 * @author     Falko Menge <mail@falko-menge.de>
 * @author     Gregor Gabrysiak <gregor_abrak at web dot de>
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @webservice
 *
 */
class HelloWorld {
    
    //==========================================================================
    /**
     * @webmethod
     * @return string
     */
    public function sayHello() {
        return 'Hello World!';
    }
}
?>
