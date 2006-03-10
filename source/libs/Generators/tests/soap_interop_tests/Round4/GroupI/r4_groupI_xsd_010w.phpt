--TEST--
SOAP Interop Round4 GroupI XSD 010 (php/wsdl): echoIntegerMultiOccurs
--SKIPIF--
<?php require_once('skipif.inc'); ?>
--FILE--
<?php
$client = new SoapClient(dirname(__FILE__)."/round4_groupI_xsd.wsdl",array("trace"=>1,"exceptions"=>0));
$client->echoIntegerMultiOccurs(array("input"=>array(22,29,36)));
echo $client->__getlastrequest();
$HTTP_RAW_POST_DATA = $client->__getlastrequest();
include("round4_groupI_xsd.inc");
echo "ok\n";
?>
--EXPECT--
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://soapinterop.org/"><SOAP-ENV:Body><ns1:echoIntegerMultiOccurs><ns1:input><ns1:integer>22</ns1:integer><ns1:integer>29</ns1:integer><ns1:integer>36</ns1:integer></ns1:input></ns1:echoIntegerMultiOccurs></SOAP-ENV:Body></SOAP-ENV:Envelope>
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://soapinterop.org/"><SOAP-ENV:Body><ns1:echoIntegerMultiOccursResponse><ns1:echoIntegerMultiOccursResult><ns1:integer>22</ns1:integer><ns1:integer>29</ns1:integer><ns1:integer>36</ns1:integer></ns1:echoIntegerMultiOccursResult></ns1:echoIntegerMultiOccursResponse></SOAP-ENV:Body></SOAP-ENV:Envelope>
ok