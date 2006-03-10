--TEST--
WSDLGenerator 002 DOCLIT for class WSDLGeneratorTest->sayFoo()
--FILE--
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */

require_once 'testclasses/class.WSDLGeneratorTest.php';
$classname = 'WSDLGeneratorTest';
$soapBinding = 0;

require_once 'WSDLGenerator001.inc';

$client = new SoapClient($wsdl_file, array("trace" => 1, "exceptions" => 0));
$client->sayFoo();
//$client = new SoapClient(NULL, array("location" => "test://", "uri" => "http://www.example.org/webservices/", "trace" => 1, "exceptions" => 0));
//$client->__soapCall("sayHello", array(), array("soapaction" => "http://www.example.org/webservices/", "uri" => "http://www.example.org/webservices/"));
echo "\n" . 'SOAP Request:' . "\n" . $myXMLBeautifier->formatString($client->__getlastrequest()) . "\n";
$HTTP_RAW_POST_DATA = $client->__getlastrequest();

require_once 'SOAPServer.inc';
?>
--EXPECT--
bool(true)

SOAP Request:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator002doclit/types"><SOAP-ENV:Body><ns1:sayFoo/></SOAP-ENV:Body></SOAP-ENV:Envelope>

SOAP Response:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator002doclit/types" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><SOAP-ENV:Body><ns1:sayFooResponse><ns1:sayFooResult><ns1:inputString>test</ns1:inputString><ns1:myInteger>20</ns1:myInteger><ns1:stringArray><xsd:string>1d2</xsd:string><xsd:string>a1d</xsd:string></ns1:stringArray><ns1:myDouble xsi:nil="true"/></ns1:sayFooResult></ns1:sayFooResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>