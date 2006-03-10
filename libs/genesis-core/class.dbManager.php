<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** DbManager - encapsulate ADOdb                                         **
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

//***** imports *************************************************************
include_once(dirname(__FILE__).'/../config/config.php');
include_once(dirname(__FILE__).'/class.config.php');
include_once(ADODB_DIR.'/adodb.inc.php');

//***** DbManager ************************************************************
/**
 * DB Connection factory returns initialized ADOConnections
 *
 * @package    libs.genesis-core
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class DbManager {
  static private $connection = null;

  //=========================================================================
  /**
   * @return ADOConnection
   */
  static public function getConnection() {
    if (self::$connection == null) {
      global $ADODB_FETCH_MODE;
      $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
      self::$connection = ADONewConnection('mysql');
      $cfg = Config::getInstance();
      if (defined('GLOBAL_DEBUG') and GLOBAL_DEBUG) {
        self::$connection->debug = true;
      }
      self::$connection->Connect($cfg->dbHost, $cfg->dbUser,
                                 $cfg->dbPassword, $cfg->dbName);
    }
    return self::$connection;
  }
}
?>