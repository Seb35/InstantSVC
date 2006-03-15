--TEST--
WSDLGenerator 002 (rpc/lit): WSDLGeneratorTest->getFoo()
--FILE--
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */

require_once 'testclasses/class.WSDLGeneratorTest.php';
$classname = 'WSDLGeneratorTest';
$soapBinding = 1;

require_once 'WSDLGenerator001.inc';

$client = new SoapClient($wsdl_file, array("trace" => 1, "exceptions" => 0));
$client->getFoo();

echo "\n" . 'SOAP Request:' . "\n" . $myXMLBeautifier->formatString($client->__getlastrequest()) . "\n";
$HTTP_RAW_POST_DATA = $client->__getlastrequest();

require_once 'SOAPServer.inc';
?>
--EXPECT--
bool(true)

SOAP Request:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator002rpclit"><SOAP-ENV:Body><ns1:getFoo/></SOAP-ENV:Body></SOAP-ENV:Envelope>

SOAP Response:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator002rpclit" xmlns:ns2="http://www.example.org/webservices/WSDLGenerator002rpclit/types" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><SOAP-ENV:Body><ns1:getFooResponse><return><ns2:inputString>test</ns2:inputString><ns2:myInteger>20</ns2:myInteger><ns2:stringArray><ns2:string>1d2</ns2:string><ns2:string>a1d</ns2:string></ns2:stringArray><ns2:myDouble xsi:nil="true"/></return></ns1:getFooResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>