<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** UsernameToken  - Datastructure for Username Token Profile             **
//**                  contains the data                                    **
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



//***** UsernameToken *******************************************************
/**
* Generate a new Username Token
*
* @package    libs.SecureClient
* @author     Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author     Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright  2006 Christoph Hartmann, Michael Perscheid 
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class UsernameToken {
  /**
  * @var string
  */
  private $Username;
  /**
  * @var string
  */
  private $Password;
  /**
  * @var string (encoded int)
  */
  private $Nonce;
  /**
  * @var timestamp
  */
  private $Created;

  //=======================================================================
  /**
  * Construct the username token header
  *
  * Web Service Security Username Token
  * http://www.oasis-open.org/
  *
  * @param string $name
  * @param string $pw
  */
  public function __construct($name, $pw) {
    $this->Username = $name;
    // Generate Nonce
    $this->Nonce = mt_rand();
    // Timestamp - ISO - Format
    $this->Created = date("c");
    // Generate Hashvalue
    $this->Password = base64_encode(
                      sha1($this->Nonce . $this->Created . md5($pw), true));
    // encode nonce in base64
    $this->Nonce = base64_encode($this->Nonce);
  } // end of __construct
} // end of class UsernameToken
?>
