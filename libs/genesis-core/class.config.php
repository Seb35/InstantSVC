<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Config - Provides settings like database connection infos             **
//**                                                                       **
//** Project: TOOLSLAVE Genesis Framework                                  **
//**                                                                       **
//** @package    libs.genesis-core                                         **
//** @author     Stefan Marr <marr@toolslave.com>                          **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
include_once(dirname(__FILE__).'/class.singleton.php');

//***** Config **************************************************************
/**
 * Provides a settings singleton for global use
 *
 * @package    libs.genesis-core
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class Config implements Singleton {

  /**
  * Die folgenden Variablen sind für den schnellen Zugriff und werden bei
  * Veränderungen nicht in die Konfiguration geschrieben!
  */

  /**
   * @var string
   */
  public $dbPrefix = '';

  /**
   * @var string
   */
 
 /**
  * @var string
  */ public $dbUser = '';

  /**
   * @var string
   */
  public $dbHost = '';

  /**
   * @var string
   */
  public $dbPassword = '';

  /**
   * @var string
   */
  public $dbName = '';


  /**
   * @var string
   */
  public $siteURL = '';
 
  /**
   * @var string
   */
  public $siteImageURL = '';


  /**
   * @var string
   */
  public $sitePath = '';

  /**
   * @var string
   */
  public $siteTitle = '';


  //=========================================================================
  private function __construct() {
    include(GENESIS_CFGFILE);

    $this->dbPrefix = $dbPrefix;
    $this->dbUser = $dbUser;
    $this->dbHost = $dbHost;
    $this->dbPassword = $dbPassword;
    $this->dbName = $dbName;

    $this->siteURL = $siteURL;
    $this->siteImageURL = $siteImageURL;
    $this->sitePath = $sitePath;
    $this->siteTitle = $siteTitle;
  } //end of __construct

  /**
   * @ var Singleton instance
   */
  private static $instance;

  //=========================================================================
  /**
   * get singleton instance
   */
  static public function getInstance() {
    if (!isset(self::$instance)) {
      self::$instance = new Config();
    }

    return self::$instance;
  }
}
?>