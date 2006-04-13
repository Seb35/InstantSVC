<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Test ExtendedSoapServer - Test the server with Username Token and     **
//**                           delete complete Soapheader                  **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package Username Token                                               **
//** @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>    **
//** @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>      **
//** @copyright 2006 Christoph Hartmann, Michael Perscheid                 **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2005-12-18 - Implement the test                           **
//**                                                                       **
//***************************************************************************
//***************************************************************************

// disable WSDL Cache for development
ini_set('soap.wsdl_cache_enabled', 0);
ini_set('soap.wsdl_cache_dir', './');
ini_set('soap.wsdl_cache_ttl', 0);

//***** imports *************************************************************
// include extended SoapServer
include_once('class.ExtendedSoapServer.php');
// include WebserviceClass
include_once(dirname(__FILE__).'/../SecureClient/test/HalloWelt.php');

// include SoapHeader-Parser
require_once(dirname(__FILE__).'/../SoapHeader/XmlSoapHeaderParser.php');

// include Security-Parser
require_once(dirname(__FILE__).'/../UserTokenProfile/XmlSoapSecParser.php');



//include a ICheckUserRunnable implementation
require_once(dirname(__FILE__).'/../UserTokenProfile/CheckUserRunnable.php');

if (php_sapi_name() == 'cli') {
    echo 'isn\'t meant to be called from commandline';
    return -1;
}

    // check UsernameToken
    $xmlUserNameTokenParser = new XmlSoapSecParser();
    $xmlUserNameTokenParser->addCheckUserRunnable(new CheckUserRunnable() );

    // delete soap header
    $xmlSoapHeaderParser = new XmlSoapHeaderParser();

    // initialize secure server
    $server = new ExtendedSoapServer(dirname(__FILE__).'/../SecureClient/test/HalloWelt.wsdl');

    // set XmlHandler
    $server->addXmlHandler($xmlUserNameTokenParser);
    $server->addXmlHandler($xmlSoapHeaderParser);

    $server->setClass('HelloWorldWebservice');
    $server->handle();

?>