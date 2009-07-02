<?php
error_reporting(E_ALL|E_STRICT);

/**
 *
 * @package    admintool
 * @author     Falko Menge <mail@falko-menge.de>
 * @author     Tobias Vogel <tobias.vogel@hpi.uni-potsdam.de>
 * @copyright  2009 InstantSVC Team
 * @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
 */

require_once(dirname(__FILE__).'/admin-tool-config.php');
require_once(dirname(__FILE__).'/admin-tool-lib.php');
//if (strpos(realpath($searchPath . $_REQUEST['id'] . '/'),realpath($searchPath)) === 0) {
//$classes = $lib->getAllClasses($searchPath);
//$simpleClasses = array();
//foreach ($classes as $name => $class) {
//if ($class['webservice']) {
//$simpleClasses[$name] = $class['file'];
//}
//}
//}


$lib = new AdminToolLibrary();

unset($_REQUEST['PHPSESSID']);
unset($_REQUEST['__utma']);
unset($_REQUEST['__utmb']);
unset($_REQUEST['__utmc']);
unset($_REQUEST['__utmz']);

//var_dump($_REQUEST);

//if (!empty($_REQUEST)) {
if (!isset($_REQUEST['folder']) or !isset($_REQUEST['classname']) or !isset($_REQUEST['filename']) or !isset($_REQUEST['servicename'])) {
  header('HTTP/1.0 400');
  die('Not all parameters were filled in');
}

$targetPath = realpath(INSTANTSVC_DEFAULT_TARGET_DIR);
$searchPath = STD_SEARCHPATH . 'generated-from-html/';
$onlyConsiderAnnotatedClasses = true;
$generatedUniqueFolder = $_REQUEST['folder']; // 123423782742389472389
$className = $_REQUEST['classname']; //Meinwebservice
$fileName = $_REQUEST['filename']; // /var/www.../123454348593485934589345893458934/Meinwebservice.php
$serviceName = $_REQUEST['servicename']; //Meinwebservice
$serviceUri = "http://posr.ws/instantsvc/services/soap.php/" . $className;
$namespace = "http://posr.ws/instantsvc/services/soap.php/" . $className;
$wsdlStyle = WSDLGenerator::RPC_LITERAL;
$wsdlPath = $targetPath . '/' . $serviceName . '.wsdl'; // /var/www/instantsvc/services     /      Meinwebservice    .wsdl
$realSearchPath = $searchPath . $generatedUniqueFolder;
$appendToExistingDeploymentDescriptor = true;
$useUTP = false;

$saved = AdminToolLibrary::generateWsdl(
  $className, 
  $fileName,
  $serviceName,
  $serviceUri,
  $namespace,
  (int) $wsdlStyle,
  $wsdlPath
);


if (!$saved) {
  header('HTTP/1.0 500');
  die('WSDL file could not be generated.');
}

// correct (purge) $targetPath
$targetPath = realPath($targetPath);



if ((int) $wsdlStyle == WSDLGenerator::DOCUMENT_WRAPPED) {
  $classfile = AdminToolLibrary::generateAdapter($className, $targetPath);
  $className = AdminToolLibrary::getAdapterClassName($className);
} else {
  $classfile = $fileName;
}


$service['wsdlfile']    = $serviceName . '.wsdl';
$service['servicename'] = $serviceName;
$service['utp']         = $useUTP;
$service['classfile']   = $classfile;
$service['classname']   = $className;

$services = array();
$services[] = $service;

AdminToolLibrary::generateDd($targetPath, $services, $appendToExistingDeploymentDescriptor);
AdminToolLibrary::generateServer($targetPath);

if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
  $protocol = 'https://';
} else {
  $protocol = 'http://';
}

$resultWsdlUri = $protocol .
           $_SERVER['HTTP_HOST'] .
           substr(realpath($targetPath), strlen(realpath($_SERVER['DOCUMENT_ROOT']))) .
           '/' .
           'soap.php/' .
           $service['servicename'] .
           '?wsdl';

header('HTTP/1.0 201');
header("Location: $resultWsdlUri");


$content = file_get_contents($resultWsdlUri);

$soapFileUri = '';
preg_match("/<wsdl:definitions .+?>/", $content, $array);
$soapFileUri = $array[0];
preg_match("/(?<=targetNamespace=\").*?(?=\/\w+\")/", $soapFileUri, $array);
$soapFileUri = $array[0];

echo $soapFileUri;


/*
<form action=autogenerate.php>
<input type=hidden name=folder value=1235428693945>
<input type=hidden name=classname value=TinyURLWebservice>
<input type=hidden name=filename value=/var/www/instantsvc/service-implementations/generated-from-html/1235428693945/TinyURLWebservice.php>
<input type=hidden name=servicename value=TinyURLWebservice>
<input type=submit>
</form>
<a href=autogenerate.php>NEUSTART</a>
Achtung, die fest eingetragenen werte dieses formulars sind vielleicht veraltet

redirect zu soap.php
*/
