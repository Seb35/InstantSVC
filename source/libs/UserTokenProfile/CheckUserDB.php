<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** CheckUserDB - asks the database if the given nonce and timestamp      **
//** already are in and check the given userdata                           **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package Username Token                                               **
//** @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>    **
//** @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>      **
//** @copyright 2005 2006 Christoph Hartmann, Michael Perscheid            **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2005-12-18 - implement the class                          **
//**                                                                       **
//***************************************************************************
//***************************************************************************

// set the path to adbdo, most likely in the php include folder
define("ADODB_DIR", "adodb\\");

require_once(ADODB_DIR.'adodb.inc.php');
require_once(ADODB_DIR.'adodb-exceptions.inc.php');

// include teleTask User Managemen
require_once("User/classes/User.php");


//***** CheckUserDB ***********************************************************
/**
* Asks the database if the given nonce and timestamp already in there
* and check the given userdata
*
* @package libs.soap.wsse
* @author  Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author  Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright  2006 Christoph Hartmann, Michael Perscheid
* @license http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class CheckUserDB {
  /**
  * @var CheckUserDB
  */
  static private $instance         = NULL;
  /**
  * @var ADOConnection
  */
  private $dbInstance              = NULL;
  /**
  * @var boolean
  */
  private $dbConnectionEstablished = FALSE;

  //=======================================================================
  /**
   * Private constructor, needed for singleton
   *
   * @return string
   */
  private function __construct() {} // end of __construct

  //=======================================================================
  /**
  * private clone, needed for singleton
  */
  private function __clone() {} // end of __clone

  //=======================================================================
  /**
  * Singleton constructor
  *
  * @return CheckUserDB
  */
  static public function getInstance() {
    if (self::$instance == NULL ) {
      self::$instance = new CheckUserDB();
    } // end if
    return self::$instance;
  } // end of getInstance

  //=======================================================================
  /**
  * Get ADO database connection
  */
  public function retrieveDbConnection() {
    // TODO put in external config
    $server = "localhost";
    $user   = "";
    $pwd    = "";
    $db     = "usertokenstorage";

    try {
      // create Database Connection
      $this->dbInstance = NewADOConnection('mysql');
      // set Parameters
      $this->dbInstance->Connect($server, $user, $pwd, $db);
      $this->dbConnectionEstablished = TRUE;
    }  // end try
	  catch (exception $e) {
      // TODO print error
    } // end catch
  }

  //=======================================================================
  /**
  * Check nonce in the database
  *
  * @param string $nonce
  * @param timestamp $timestamp
  * @param timestamp $maxLifeTime
  * @return boolean
  */
  public function isNonceOkay($nonce , $timestamp, $maxLifeTime) {
    // if connection is not established
    if ($this->dbConnectionEstablished == FALSE) {
      $this->retrieveDbConnection();
    } // end if

    // if connection is established
    if ($this->dbConnectionEstablished == TRUE) {
      try {
        $db = $this->dbInstance;

		// delete old values in the database
        $resetTime = time() - $maxLifeTime;
		$sql = "DELETE FROM usertoken WHERE ".
		       "timestamp < FROM_UNIXTIME($resetTime)";

		if ($db->Execute($sql) === FALSE) {
			return FALSE;
        } // end if

		// try to insert the nonce value
        $sql = "INSERT INTO usertoken (nonce, timestamp) ".
		       "VALUES ('$nonce', FROM_UNIXTIME('$timestamp'))";

		if ($db->Execute($sql) === FALSE) {
            // error while inserting (the value already exsist)
            return FALSE;
        } // end if

		// nonce ok
        return TRUE;

      } // end try
	  catch (exception $e) {
        // an database error occur
        return FALSE;
      } // end catch
    } // end if
    return FALSE;
  } // end of isNonceOkay

  private function setGlobalUser($account){
    // set global user object
    $GLOBALS['USER'] = $account;
  }

  // TODO Kommentare bauen
  public function setGuestAccount() {
    $this->setGlobalUser(User::getInstanceGuest());
  }

  public function setAccount($username) {
    $account = User::getInstanceFromUsername($username);
    $this->setGlobalUser($account);
  }

  public function getPassword($username) {
    $account = User::getInstanceFromUsername($username);
    return $account->getPassword();
  }

} // end of class CheckUserDB
?>