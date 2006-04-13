<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Hello World - TestClass                                               **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    WSDLGenerator                                             **
//** @author     Gregor Gabrysiak <gregor_abrak at web dot de>             **
//** @author     Falko Menge <mail@falko-menge.de>                         **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2005-2006 ...                                             **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** HelloWorld **********************************************************
/**
 * @package    libs.generator
 * @author     Gregor Gabrysiak <gregor_abrak at web dot de>
 * @author     Falko Menge <mail@falko-menge.de>
 * @author     Stefan Marr <mail@stefan-marr.de>
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
