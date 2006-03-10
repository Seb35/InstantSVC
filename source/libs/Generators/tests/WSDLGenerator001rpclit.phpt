--TEST--
WSDLGenerator 001 RPCLIT for class HelloWorld
--FILE--
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */

require_once 'testclasses/class.HelloWorld.php';
$classname = 'HelloWorld';
$soapBinding = 1;

require_once 'WSDLGenerator001.inc';

$client = new SoapClient($wsdl_file, array("trace" => 1, "exceptions" => 0));
$client->sayHello();
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
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator001rpclit"><SOAP-ENV:Body><ns1:sayHello/></SOAP-ENV:Body></SOAP-ENV:Envelope>

SOAP Response:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator001rpclit"><SOAP-ENV:Body><ns1:sayHelloResponse><return>Hello World!</return></ns1:sayHelloResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>