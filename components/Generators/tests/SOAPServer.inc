<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */

if ($soapBinding == 0) {
    require_once(dirname(__FILE__).'/../class.DocumentWrappedAdapterGenerator.php');
    $myDocumentWrappedAdapterGenerator = new DocumentWrappedAdapterGenerator($classname);
    eval($myDocumentWrappedAdapterGenerator->getAdapterClass());
    $classname = $myDocumentWrappedAdapterGenerator->getAdapterClassName();
}

$server = new SoapServer($wsdl_file);
$server->setClass($classname);
ob_start();
//$myWSDLGenerator->saveToFileAndStartSOAPServer($wsdl_file);
$server->handle();
$soapResponse = ob_get_contents();
ob_end_clean();
echo 'SOAP Response:' . "\n" . $myXMLBeautifier->formatString($soapResponse);

//unlink($wsdl_file);
?>