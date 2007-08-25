<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */
error_reporting(E_ALL);

if ($soapBinding == 0) {
    require_once(dirname(__FILE__).'/../../Soap/src/adapter_generator.php');
    $myDocumentWrappedAdapterGenerator = new iscSoapAdapterGenerator($classname);
    eval($myDocumentWrappedAdapterGenerator->getAdapterClass());
    $classname = $myDocumentWrappedAdapterGenerator->getAdapterClassName();
    
    $test = new $classname();
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