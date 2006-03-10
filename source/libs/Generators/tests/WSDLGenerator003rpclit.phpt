--TEST--
WSDLGenerator 003 RPCLIT for class WSDLGeneratorTest->sayFooOverload($fool)
--FILE--
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */

require_once 'testclasses/class.Foo.php';
require_once 'testclasses/class.WSDLGeneratorTest.php';
$classname = 'WSDLGeneratorTest';
$soapBinding = 1;

require_once 'WSDLGenerator001.inc';

$fool = new Foo();

$client = new SoapClient($wsdl_file, array("trace" => 1, "exceptions" => 0));
$client->sayFooOverload(array('fool' => $fool));
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
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator003rpclit" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><SOAP-ENV:Body><ns1:sayFooOverload><fool><item><key>fool</key><value><inputString>test</inputString><myInteger>20</myInteger><stringArray><xsd:string>1d2</xsd:string><xsd:string>a1d</xsd:string></stringArray><myDouble/></value></item></fool></ns1:sayFooOverload></SOAP-ENV:Body></SOAP-ENV:Envelope>

SOAP Response:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator003rpclit" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns2="http://www.example.org/webservices/WSDLGenerator003rpclit/types"><SOAP-ENV:Body><ns1:sayFooOverloadResponse><return><ns2:Foo><item><key>fool</key><value><inputString>test</inputString><myInteger>20</myInteger><stringArray><string><xsd:string>1d2</xsd:string><xsd:string>a1d</xsd:string></string></stringArray><myDouble></myDouble></value></item></ns2:Foo><ns2:Foo><item><key>fool</key><value><inputString>test</inputString><myInteger>20</myInteger><stringArray><string><xsd:string>1d2</xsd:string><xsd:string>a1d</xsd:string></string></stringArray><myDouble></myDouble></value></item></ns2:Foo></return></ns1:sayFooOverloadResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>