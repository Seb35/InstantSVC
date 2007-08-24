--TEST--
WSDLGenerator 003 (rpc/lit): WSDLGeneratorTest->duplicateFoo(Foo)
--FILE--
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */

require_once 'testclasses/foo.php';
require_once 'testclasses/service.php';
$classname = 'Service';
$soapBinding = 1;

require_once 'WSDLGenerator001.inc';

$client = new SoapClient($wsdl_file, array("trace" => 1, "exceptions" => 0));
$client->duplicateFoo(new Foo());

echo "\n" . 'SOAP Request:' . "\n" . $myXMLBeautifier->formatString($client->__getlastrequest()) . "\n";
$HTTP_RAW_POST_DATA = $client->__getlastrequest();

require_once 'SOAPServer.inc';
?>
--EXPECT--
bool(true)

SOAP Request:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator003rpclit" xmlns:ns2="http://www.example.org/webservices/WSDLGenerator003rpclit/types" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><SOAP-ENV:Body><ns1:duplicateFoo><inputFoo><ns2:inputString>test</ns2:inputString><ns2:myInteger>20</ns2:myInteger><ns2:stringArray><ns2:string>1d2</ns2:string><ns2:string>a1d</ns2:string></ns2:stringArray><ns2:myDouble xsi:nil="true"/></inputFoo></ns1:duplicateFoo></SOAP-ENV:Body></SOAP-ENV:Envelope>

SOAP Response:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator003rpclit" xmlns:ns2="http://www.example.org/webservices/WSDLGenerator003rpclit/types" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><SOAP-ENV:Body><ns1:duplicateFooResponse><return><ns2:Foo><ns2:inputString>test</ns2:inputString><ns2:myInteger>20</ns2:myInteger><ns2:stringArray><ns2:string>1d2</ns2:string><ns2:string>a1d</ns2:string></ns2:stringArray><ns2:myDouble xsi:nil="true"/></ns2:Foo><ns2:Foo><ns2:inputString>test</ns2:inputString><ns2:myInteger>20</ns2:myInteger><ns2:stringArray><ns2:string>1d2</ns2:string><ns2:string>a1d</ns2:string></ns2:stringArray><ns2:myDouble xsi:nil="true"/></ns2:Foo></return></ns1:duplicateFooResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>