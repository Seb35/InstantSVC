<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** CheckUserRunnable - Implemtents the algorithm for validating  a user  **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package Username Token                                               **
//** @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>    **
//** @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>      **
//** @copyright 2006 ....                                                  **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2006-02-27 - Bugfix                                       **
//**                                                                       **
//***************************************************************************
//***************************************************************************

// CheckUser - Interface
require_once('ICheckUserRunnable.php');
// Database class
require_once('CheckUserDB.php');

//***** CheckUserRunnable ***************************************************
/**
* Implement the Interface ICheckUserRunnable
*
* Implement the Web Service Security Username Token
* http://www.oasis-open.org/
*
* @package libs.soap.wsse
* @author  Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author  Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright  2006 ....
* @license http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class CheckUserRunnable implements ICheckUserRunnable {
  /**
  * @var timestamp
  */
  private $maxNounceTime = 300; // 5 min * 60 sec

  //=======================================================================
  /**
  * Check the Username Token data and return valid or an errorcode
  *
  * @param string $username
  * @param string $password
  * @param encoded integer $nonce
  * @param timestamp $created
  * @return integer
  */
  public function run ($username, $password, $nonce, $created) {
    $username  = trim($username);
    $password  = trim($password);
    $nonce     = trim($nonce);
    $created   = trim($created);

    // check, if data complete
    if (($nonce == '') xor ($created == '')) {
      // Error: created or nonce fail
      return -101;
    }
    // username and password as plain text
    elseif (empty($nonce) && empty($created)) {
      $localPassword = $this->getPassword($username);
      if ($localPassword == "") {
        // Error: account not available
        return -104;
      }
      // check user password from database against
      // md5 hashed sendet plain text pwd
      if ($localPassword == $password ) {
        // TODO: Create global object
			  $this->setAccount($username);
			  return 0;
      }
      else {
        return -105;
      }

    }
	  else {
      // extract timestamp from given time
      $timestamp = strtotime($created);
	    // check the age
      if ($this->checkAge($timestamp, $this->maxNounceTime) != TRUE) {
        // Error: overage
        return -106;
      } // end if
	    else {
        $nonce = base64_decode($nonce);
        if ($this->checkNonce($nonce,
						$timestamp,
						$this->maxNounceTime) != TRUE) {
          // Error: nonce already exsist
          return -106;
        } // end if
		    else {
          // get encrypted password
          $localPassword = $this->getPassword($username);

          if ($localPassword == "") {
            // Error: account not available
            return -104;
            } // end if
		      else {
            // create comparison
            $comparison = sha1($nonce.$created.$localPassword, true);

            // check the hashcodes
            if ($comparison != base64_decode($password)) {
              // Error: False password
              return -105;
            } // end if
			      else {
              // TODO: Create global object
              $this->setAccount($username);
              return 0;
            } // end else
          } // end else
        } // end else
      } // end else
    } // end else
  } // end of run

  //=======================================================================
  /**
  * check the age of the timestamp
  *
  * @param timestamp $timestamp
  * @param timestamp $age
  * @return boolean
  */
  private function checkAge($timestamp, $age) {
    $diff = time() - $timestamp;

    if ( ($diff >= 0) && ($diff < $age)) {
      return TRUE;
    } // end if
	else {
      return FALSE;
    } // end else
  } // end of checkAge

  //=======================================================================
  /**
  * check if nonce is already in database
  *
  * @param integer $nonce
  * @param timestamp $timestamp
  * @return boolean
  */
  private function checkNonce($nonce,$timestamp) {

     $checkUserDB = CheckUserDB::getInstance();
     return $checkUserDB->isNonceOkay($nonce,$timestamp,$this->maxNounceTime);
  } // end of checkNonce

  //=======================================================================
  /**
  * set the guest account
  *
  * @return IUser
  */
  public function setGuestAccount() {
    $checkUserDB = CheckUserDB::getInstance();
     return $checkUserDB->setGuestAccount();
  }

  //=======================================================================
  /**
  * set the authorized account
  *
  * @param string $username
  * @return IUser
  */
  public function setAccount($username) {
    $checkUserDB = CheckUserDB::getInstance();
     return $checkUserDB->setAccount($username);
  }

  //=======================================================================
  /**
  * retrieve a md5 hashed password from the user
  *
  * @param string $username
  * @return string
  */
  public function getPassword($username) {
    $checkUserDB = CheckUserDB::getInstance();
     return $checkUserDB->getPassword($username);
  }
} // end of class CheckUserRunnable
?>