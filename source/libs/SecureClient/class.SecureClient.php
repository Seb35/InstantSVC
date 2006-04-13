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
//** @copyright 2006 Christoph Hartmann, Michael Perscheid                 **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2005-12-18 - First implementation                         **
//** @lastchange 2006-02-04 - Generate automatically                       **
//**                          new header with each __call                  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

// base datastructure
require_once('./UserTokenProfile/class.SecurityStruct.php');

//***** SecureSoapClient *******************************************************
/**
* Extend the class SoapClient (PHP 5 Class) with the Username Token Header
*
* @package    Secure Client
* @author     Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author     Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright  2006 Christoph Hartmann, Michael Perscheid 
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