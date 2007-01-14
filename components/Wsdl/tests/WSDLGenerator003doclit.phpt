--TEST--
WSDLGenerator 003 (doc/lit): WSDLGeneratorTest->duplicateFoo(Foo)
--FILE--
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */

require_once 'testclasses/class.Foo.php';
require_once 'testclasses/class.WSDLGeneratorTest.php';
$classname = 'WSDLGeneratorTest';
$soapBinding = 0;

require_once 'WSDLGenerator001.inc';

$inputFoo = new Foo();

$client = new SoapClient($wsdl_file, array("trace" => 1, "exceptions" => 0));
$client->duplicateFoo(array('inputFoo' => $inputFoo));

echo "\n" . 'SOAP Request:' . "\n" . $myXMLBeautifier->formatString($client->__getlastrequest()) . "\n";
$HTTP_RAW_POST_DATA = $client->__getlastrequest();

require_once 'SOAPServer.inc';
?>
--EXPECT--
bool(true)

SOAP Request:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator003doclit/types" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><SOAP-ENV:Body><ns1:duplicateFoo><ns1:inputFoo><ns1:inputString>test</ns1:inputString><ns1:myInteger>20</ns1:myInteger><ns1:stringArray><ns1:string>1d2</ns1:string><ns1:string>a1d</ns1:string></ns1:stringArray><ns1:myDouble xsi:nil="true"/></ns1:inputFoo></ns1:duplicateFoo></SOAP-ENV:Body></SOAP-ENV:Envelope>

SOAP Response:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator003doclit/types" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><SOAP-ENV:Body><ns1:duplicateFooResponse><ns1:duplicateFooResult><ns1:Foo><ns1:inputString>test</ns1:inputString><ns1:myInteger>20</ns1:myInteger><ns1:stringArray><ns1:string>1d2</ns1:string><ns1:string>a1d</ns1:string></ns1:stringArray><ns1:myDouble xsi:nil="true"/></ns1:Foo><ns1:Foo><ns1:inputString>test</ns1:inputString><ns1:myInteger>20</ns1:myInteger><ns1:stringArray><ns1:string>1d2</ns1:string><ns1:string>a1d</ns1:string></ns1:stringArray><ns1:myDouble xsi:nil="true"/></ns1:Foo></ns1:duplicateFooResult></ns1:duplicateFooResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>