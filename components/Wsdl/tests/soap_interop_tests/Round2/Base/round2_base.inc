<?php
require_once 'class.SOAP_Interop_Base.php';

$server = new SoapServer(dirname(__FILE__)."/round2_base.wsdl");
$server->setClass("SOAP_Interop_Base");
$server->handle();
?>