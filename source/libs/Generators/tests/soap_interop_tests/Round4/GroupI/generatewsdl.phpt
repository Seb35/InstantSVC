--TEST--
SOAP Interop Round4 GroupI XSD WSDL generation
--FILE--
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . dirname(__FILE__) . '/../../../../../');

require_once 'Generators/class.WSDLGenerator.php';
require_once 'class.SOAP_Interop_GroupI.php';
$classname = 'SOAP_Interop_GroupI';
$wsdl_file = dirname(__FILE__) . '/round4_groupI_xsd.wsdl';
$service_access_point = 'round4_groupI_xsd.inc';
$namespace = 'http://soapinterop.org/';
$typeNamespace = $namespace . 'xsd';

$myWSDLGenerator = new WSDLGenerator(
        $classname,
        $service_access_point ,
        $namespace,
        WSDLGenerator::DOCUMENT_WRAPPED);
//$myWSDLGenerator->setTypeNamespace($typeNamespace);
$myWSDLGenerator->setClass($classname);
$wsdl = $myWSDLGenerator->saveToFile($wsdl_file);
var_dump(file_exists($wsdl_file));

require_once 'Generators/class.DocumentWrappedAdapterGenerator.php';
$myDocumentWrappedAdapterGenerator = new DocumentWrappedAdapterGenerator($classname, NULL, 'SOAP_Interop_GroupIDocumentWrappedAdapter');
var_dump(file_exists($myDocumentWrappedAdapterGenerator->saveToFile(dirname(__FILE__), 'class.SOAP_Interop_GroupIDocumentWrappedAdapter.php')));
?>
--EXPECT--
bool(true)
bool(true)
