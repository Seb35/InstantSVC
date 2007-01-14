--TEST--
WSDLGenerator 003 (rpc/enc): WSDLGeneratorTest->duplicateFoo(Foo)
--FILE--
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */

require_once 'testclasses/class.Foo.php';
require_once 'testclasses/class.WSDLGeneratorTest.php';
$classname = 'WSDLGeneratorTest';
$soapBinding = 2;

require_once 'WSDLGenerator001.inc';

$inputFoo = new Foo();

$client = new SoapClient($wsdl_file, array("trace" => 1, "exceptions" => 0));
$client->duplicateFoo($inputFoo);

echo "\n" . 'SOAP Request:' . "\n" . $myXMLBeautifier->formatString($client->__getlastrequest()) . "\n";
$HTTP_RAW_POST_DATA = $client->__getlastrequest();

require_once 'SOAPServer.inc';
?>
--EXPECT--
bool(true)

SOAP Request:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator003rpcenc" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns2="http://www.example.org/webservices/WSDLGenerator003rpcenc/types" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><SOAP-ENV:Body><ns1:duplicateFoo><inputFoo xsi:type="ns2:Foo"><inputString xsi:type="xsd:string">test</inputString><myInteger xsi:type="xsd:int">20</myInteger><stringArray SOAP-ENC:arrayType="xsd:string[2]" xsi:type="ns2:ArrayOfstring"><item xsi:type="xsd:string">1d2</item><item xsi:type="xsd:string">a1d</item></stringArray><myDouble xsi:nil="true"/></inputFoo></ns1:duplicateFoo></SOAP-ENV:Body></SOAP-ENV:Envelope>

SOAP Response:
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://www.example.org/webservices/WSDLGenerator003rpcenc" xmlns:ns2="http://www.example.org/webservices/WSDLGenerator003rpcenc/types" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><SOAP-ENV:Body><ns1:duplicateFooResponse><return SOAP-ENC:arrayType="ns2:Foo[2]" xsi:type="ns2:ArrayOfFoo"><item xsi:type="ns2:Foo"><inputString xsi:type="xsd:string">test</inputString><myInteger xsi:type="xsd:int">20</myInteger><stringArray SOAP-ENC:arrayType="xsd:string[2]" xsi:type="ns2:ArrayOfstring"><item xsi:type="xsd:string">1d2</item><item xsi:type="xsd:string">a1d</item></stringArray><myDouble xsi:nil="true"/></item><item xsi:type="ns2:Foo"><inputString xsi:type="xsd:string">test</inputString><myInteger xsi:type="xsd:int">20</myInteger><stringArray SOAP-ENC:arrayType="xsd:string[2]" xsi:type="ns2:ArrayOfstring"><item xsi:type="xsd:string">1d2</item><item xsi:type="xsd:string">a1d</item></stringArray><myDouble xsi:nil="true"/></item></return></ns1:duplicateFooResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>