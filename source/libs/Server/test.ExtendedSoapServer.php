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
//** @copyright 2006 ....                                                  **
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
include('Server/ExtendedSoapServer.php');
// include WebserviceClass
include('Webservice/HalloWelt.php');

// include Security-Parser
require_once('Server/Parser/XmlSoapSecParser.php');

// include SoapHeader-Parser
require_once('Server/Parser/XmlSoapHeaderParser.php');

//include a ICheckUserRunnable implementation
require_once('Server/Parser/CheckUserRunnable.php');

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
    $server = new ExtendedSoapServer('Webservice/HalloWelt.wsdl');

    // set XmlHandler
    $server->addXmlHandler($xmlUserNameTokenParser);
    $server->addXmlHandler($xmlSoapHeaderParser);

    $server->setClass('HelloWorldWebservice');
    $server->handle();

?>
