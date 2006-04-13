<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** SecurityStruct - Datastructure for Username Token Profile             **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package Secure Client                                                **
//** @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>    **
//** @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>      **
//** @copyright 2006 Christoph Hartmann, Michael Perscheid                 **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2006-04-13 - Separation form client implementation        **
//**                                                                       **
//***************************************************************************
//***************************************************************************

// base datastructure
require_once('class.UsernameToken.php');

//***** SecurityStruct *******************************************************
/**
* Encapsulate the class UsernameToken
*
* @package    Secure Client
* @author     Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author     Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright  2006 Christoph Hartmann, Michael Perscheid 
* @license    @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class SecurityStruct {
  //=======================================================================
  /**
  * Construct the class UsernameToken
  *
  * Class UsernameToken is a struct which must be implemented in another class,
  * so that PHP can construct the SoapHeaderVar
  *
  * @param string $name
  * @param string $pw
  */
  public function SecurityStruct($name, $pw)
  {
    $this->UsernameToken = new UsernameToken($name, $pw);
  } // end of __construct
} // end of class SecurityStruct


?>
