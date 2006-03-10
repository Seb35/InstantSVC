<?php
require_once('class.SOAP_Interop_GroupI.php');
require_once('class.SOAP_Interop_GroupIDocumentWrappedAdapter.php');

$server = new SoapServer(dirname(__FILE__) . "/round4_groupI_xsd.wsdl");
$server->setClass("SOAP_Interop_GroupIDocumentWrappedAdapter");
$server->handle();
?>
