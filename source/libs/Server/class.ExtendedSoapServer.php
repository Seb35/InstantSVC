<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ExtendedSoapServer - extend the SoapServer (PHP 5)                    **
//**                      and handle Soapparser                            **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package Username Token                                               **
//** @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>    **
//** @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>      **
//** @copyright 2006 Christoph Hartmann, Michael Perscheid                 **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2005-12-18 - Implement the class                          **
//**                                                                       **
//***************************************************************************
//***************************************************************************

define("DEBUG", FALSE);

//***** ExtendedSoapServer **************************************************
/**
* This class realise a Soap Server with a chain handler for soapparser
*
* @package Username Token
* @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright 2006 Christoph Hartmann, Michael Perscheid 
* @license @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class ExtendedSoapServer {

  /**
  * @var string
  */
  private $wsdlfile = "";

  /**
  * @var array<string,mixed>
  */
  private $serverParams = array();

  /**
  * @var string
  */
  private $webClass = "";
  /**
  * @var string
  */
  private $soapMessage = "";
  /**
  * @var object[]
  */
  private $xmlParserArray = array();

  //=======================================================================
  /**
  * constructor save the wsdl file
  *
  * @param string $wsdlFile
  * @param array<string,mixed> $params
  */
  public function __construct($wsdlFile, $params = array()) {
    $this->wsdlfile = $wsdlFile;
    $this->serverParams = $params;
  } // end of __constructor

  //=======================================================================
  /**
  * Set the Web Service class
  *
  * @param string $webClass
  */
  public function setClass($webClass) {
    $this->webClass = $webClass;
  }

  //=======================================================================
  /**
  * add a new Xml handler which parse the soap message
  *
  * @param object $xmlHandler
  */
  public function addXmlHandler($xmlHandler) {
    if (is_a($xmlHandler,'XmlParserExtended')) {
	  $this->xmlParserArray[] = $xmlHandler;
    } // end if
  } // end of addXmlHandler

  //=======================================================================
  /**
  * handle all Serverrequests
  */
  public function handle() {

    // --------------------------------------------------------
    // global Access
    global $HTTP_RAW_POST_DATA;

    // --------------------------------------------------------
    // Debug Message
    if (defined("DEBUG") && DEBUG) {
      // For testing the server response his own Soap message
    	// Update the security tags
    	// Just works with the HalloWelt Web Service
      // Just insert your message here if needed
      $xml_soap_request = "";

      // load local request or the request send by the client
      if (!isset( $HTTP_RAW_POST_DATA)) {
        $HTTP_RAW_POST_DATA = $xml_soap_request;
      } // end if
    }

    // --------------------------------------------------------
    // Main APP
    $xmlHandlerError = 0;

    foreach($this->xmlParserArray as $value) {
      $error = $value->parse($HTTP_RAW_POST_DATA);
	  // catch first error
	  if (($error != 0) && ($xmlHandlerError == 0)) {
	    $xmlHandlerError =  $error;
	  } // end if
      $HTTP_RAW_POST_DATA = $value->deleteHeader();
    } // end foreach

    // real server
    if ($xmlHandlerError == 0) {

      try {
        $server = new SoapServer($this->wsdlfile, $this->serverParams);
        $server->setClass($this->webClass);
        $server->handle();
      } // end try
      catch (SOAPFault $f) {
        print $f->faultstring;
      } // end catch
    } // end if
    // Error Handling
    else {
        $faultCode = "Error";
		$faultString = "An undefined error occurs";
    // Wir werden eine PDF Datei ausgeben
    header('Content-type: text/xml');
		switch($xmlHandlerError)
   		{
   			case -101:
			    $faultCode = "wsse:UnsupportedSecurityToken";
			   	$faultString = "An unsupported token was provided";
					break;
   			case -102:
			    $faultCode = "wsse:UnsupportedAlgorithm";
			   	$faultString = "An unsupported signature or encryption algorithm was used";
					break;
   			case -103:
			    $faultCode = "wsse:InvalidSecurity";
			   	$faultString = "An error was discovered processing the <wsse:Security> header";
					break;
   			case -104:
			    $faultCode = "wsse:InvalidSecurityToken";
			   	$faultString = "An invalid security token was provided";
					break;
   			case -105:
			    $faultCode = "wsse:FailedAuthentication";
			   	$faultString = "The security token could not be authenticated or authorized";
					break;
   			case -106:
			    $faultCode = "wsse:FailedCheck";
			   	$faultString = "The signature or decryption was invalid";
					break;
   			case -107:
			    $faultCode = "wsse:SecurityTokenUnavailable";
			   	$faultString = "Referenced security token could not be retrieved";
					break;
	    } // end switch

      try {
        $server = new SoapServer($this->wsdlfile);
        $server->fault($faultCode, $faultString);
      } // end try
      catch (SOAPFault $f) {
        print $f->faultstring;
      } // end catch
    } // end else
  } // end of handle
} // end of class ExtendedSoapServer


?>