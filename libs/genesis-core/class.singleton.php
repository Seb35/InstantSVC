<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Singleton - interface meant to standardize singleton handling         **
//**                                                                       **
//** Project: TOOLSLAVE Genesis Framework                                  **
//**                                                                       **
//** @package    genesis-core                                              **
//** @author     Stefan Marr <marr@toolslave.com>                          **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** Singleton ***********************************************************
/**
 * @package    libs.genesis-core
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
interface Singleton {

  //=========================================================================
  /**
   * @return Singleton
   */
  static public function getInstance();
}
?>