<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ICheckUserRunnable - Interface for validating  a user                 **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package Security Interface                                           **
//** @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>    **
//** @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>      **
//** @copyright 2006 2006 Christoph Hartmann, Michael Perscheid            **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2005-12-18 - define the interface                         **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** interface ICheckUserRunnable ****************************************
/**
* Interface for validating  a user
*
* @package libs.misc
* @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright 2006 Christoph Hartmann, Michael Perscheid
* @license http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
interface ICheckUserRunnable {

  //=======================================================================
  /**
   * interfacemethod for validating a user
   *
   * @param string $username
   * @param string $password
   * @param string $nonce
   * @param string $created
   * @return integer
   */
  public function run($username, $password, $nonce, $created);
} // end of interface ICheckUserRunnable
?>