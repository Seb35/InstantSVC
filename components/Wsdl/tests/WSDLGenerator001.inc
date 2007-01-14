<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */


// All errors must be reported
error_reporting( E_ALL | E_STRICT );

ini_set( 'include_path', getcwd(). PATH_SEPARATOR . dirname( __FILE__ ) . '/../..' . PATH_SEPARATOR . ini_get( 'include_path' ) );

// configuring the ezc autoloading
require_once("Base/src/base.php");
function __autoload( $className )
{
    if ( strpos( $className, "_" ) !== false )
    {
        $file = str_replace( "_", "/", $className ) . ".php";
        $val = require_once( $file );
        if ( $val == 0 )
            return true;
        return false;
    }
    ezcBase::autoload( $className );
}


if (substr($_SERVER['SCRIPT_NAME'], -5) == '.phpt') {
    $testCase = basename($_SERVER['SCRIPT_NAME'], '.phpt');
} else {
    $testCase = substr(basename($_SERVER['SCRIPT_NAME']),0,-4);
}
$wsdl_file = $testCase . '.wsdl';
//$service_access_point = 'http://www.example.org/webservices/' . $testCase;
$service_access_point = 'test://';
$namespace = 'http://www.example.org/webservices/' . $testCase;
$typeNamespace = 'http://www.example.org/webservices/' . $testCase . '/types';

$myWSDLGenerator = new isvcWsdlGenerator(
    $classname,
    $service_access_point,
    $namespace,
    $soapBinding);

$myWSDLGenerator->setTypeNamespace($typeNamespace);
$myWSDLGenerator->setClass($classname);
$wsdl = $myWSDLGenerator->saveToFile($wsdl_file);
clearstatcache();
var_dump(file_exists($wsdl_file));

/*
echo "\n" . 'XMLSchema validation of the generated WSDL document:' . "\n";
$dom = $myWSDLGenerator->getDOMDocument();
//$result = $dom->schemaValidate('wsdl-2003-02-11.xsd');
//$result = $dom->schemaValidate('wsdl-2003-02-11-new.xsd');
//$result = $dom->schemaValidate('wsdl-1.1.xsd');
var_dump($result);
//*/

$enableXMLBeautifier = false; //should be false for automated regression testing
if ($enableXMLBeautifier and @include_once('XML/Beautifier.php')) {
    //$result = $myXMLBeautifier->formatFile($wsdl_file, XML_BEAUTIFIER_OVERWRITE);
} else {
    class XML_Beautifier {
        function formatString($string) {
            return $string;
        }
    }
}
$myXMLBeautifier = new XML_Beautifier();

//*/
?>