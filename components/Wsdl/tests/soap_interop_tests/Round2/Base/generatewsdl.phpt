--TEST--
SOAP Interop Round2 base WSDL generation
--FILE--
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */

//ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . dirname(__FILE__) . '/../../../../../');

require_once 'ezc/Base/base.php';
function __autoload( $className ) { ezcBase::autoload( $className ); }
require_once dirname(__FILE__).'/../../../../src/interfaces/wsdl_generator_plugin.php';
require_once dirname(__FILE__).'/../../../../src/wsdl_generator.php';

require_once 'class.SOAP_Interop_Base.php';
$classname = 'SOAP_Interop_Base';
$wsdl_file = dirname(__FILE__)."/round2_base.wsdl";
$service_access_point = 'round2_base.inc';
$namespace = 'http://soapinterop.org/';
$typeNamespace = $namespace . 'xsd';

$myWSDLGenerator = new iscWsdlGenerator(
        $classname,
        $service_access_point ,
        $namespace,
        iscWsdlGenerator::RPC_ENCODED);
$myWSDLGenerator->setTypeNamespace($typeNamespace);
$myWSDLGenerator->setClass($classname);
$wsdl = $myWSDLGenerator->saveToFile($wsdl_file);
var_dump(file_exists($wsdl_file));
?>
--EXPECT--
bool(true)
