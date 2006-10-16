<?php
//***************************************************************************
//***************************************************************************
//**                                                                       ** 
//** HelloWorld WebService - an easy webservice                            ** 
//**                                                                       ** 
//** Project: Web Services Security                                        ** 
//**                                                                       ** 
//** @package Paketname                                                    ** 
//** @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>    ** 
//** @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>      **
//** @copyright 2005 ....                                                  ** 
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2005-12-18 - Details zur Änderung                         ** 
//**                                                                       ** 
//***************************************************************************
//***************************************************************************

//***** ClassName ***********************************************************
/** 
* This class contains a very simple hello world web service. It is mainly 
* user for testing purposes.
* 
* @package webservices.security 
* @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright 2005 .... 
* @license @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0 
*/
class HelloWorldWebservice {

  //=========================================================================
  /**
   * @param string $string
   * @return string
   */

  public function halloWelt($string) {
  $name = $GLOBALS['USER']->getUsername();
  
  return  " $string -> mit Account $name";
  }
}
?>