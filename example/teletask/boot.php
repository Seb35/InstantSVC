<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** boot.php - init framework, setup necessary configuration              **
//**		  - includes all required library files                        **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** 2005 by Andreas Meyer, Sebastian Böttner, Stefan Marr                 **
//**                                                                       **
//** last change: 2005-10-27 Stefan Marr                                   **
//**                                                                       **
//***************************************************************************
//***************************************************************************

/**
 * @package    example.teletask
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */

//require_once(dirname(__FILE__).'/constants.php');

//***** Initialisieren globaler Konstanten **********************************
define("GLOBAL_DEBUG", true);


/**
* Setzen von Einstellungen in der php.ini
*/
ini_set('arg_separator.output', '&amp;');  //Für XHTML Konforme Augabe
ini_set('session.use_trans_sid', false);


//Debugmode Aktivieren?
if (defined("GLOBAL_DEBUG") and GLOBAL_DEBUG) {
  error_reporting(E_ALL/*|E_STRICT*/);
} //end if
else {
  error_reporting(0);
} //end else

?>