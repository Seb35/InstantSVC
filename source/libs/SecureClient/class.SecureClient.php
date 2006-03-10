<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** SecureSoapClient - SecureSoapClient encapsulate the                   **
//**                    SoapClient with the Username Token                 **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package Secure Client                                                **
//** @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>    **
//** @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>      **
//** @copyright 2006                                                       **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2005-12-18 - First implementation                         **
//** @lastchange 2006-02-04 - Generate automatically                       **
//**                          new header with each __call                  **
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
* @copyright  2006 ....
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

//***** SecurityStruct *******************************************************
/**
* Encapsulate the class UsernameToken
*
* @package    Secure Client
* @author     Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author     Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright  2006 ....
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

//***** SecureSoapClient *******************************************************
/**
* Extend the class SoapClient (PHP 5 Class) with the Username Token Header
*
* @package    Secure Client
* @author     Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author     Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright  2006 ....
* @license    @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class SecureSoapClient extends SoapClient {
  /**
  * @var string
  */
  private $account = "";
  /**
  * @var string
  */
  private $password = "";

  //=======================================================================
  /**
  * Extended Soap constructor which save username and password
  *
  * @param string $wsdl
  * @param string[] $options
  * @param string $name
  * @param string $pw
  */
  public function __construct($wsdl , $options, $user, $pw) {

	$this->account = $user;
	$this->password = $pw;

    parent::__construct($wsdl , $options);
  } // end of __construct

  //=======================================================================
  /**
  * Extended Soap __call Method to generate automatically a
  * new Username Token
  *
  * @param string $function_name
  * @param object[] $arguments
  */
  public function __call($function_name, $arguments){

    // delete header
    $this->__setSoapHeaders(null);

	if (($this->account != "") && ($this->password != "")) {

	  $auth = new SoapVar(
	          new SecurityStruct($this->account,
						         $this->password),
              SOAP_ENC_OBJECT);

	  $header =  new SoapHeader(
                'http:/docs.oasis-open.org/wss/'.
				'oasis-wss-wsssecurity-secext-1.0.xsd/',
		        'Security',
		        $auth);

	  $this->__setSoapHeaders(array($header));
	} // end if

    // delegate to parent class
	return parent::__call($function_name, $arguments);
  } // end of __call
} // end of class SecureSoapClient
?>