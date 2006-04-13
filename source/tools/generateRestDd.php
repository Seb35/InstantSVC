#!/usr/bin/php5.1
<?php

//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Console script to generate a rest.dd.php file				   **
//**                                                                       **
//** @package    tools									   **
//** @author     Stefan Marr <marr@stefan-marr.de>                         **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once('../../libs/misc/class.console.php');


error_reporting(E_ALL);
$console = new Console();
$args = $console->getArgs('?a:s:d:f:b:');
//look through the cmd line args to know what to do now

$opts = $args[0];
$noneOpts = $args[1];

//Setup default values for params
$params['a'] = null;
$params['s'] = 'PearSerializer';
$params['d'] = null;
$params['f'] = null;
$params['b'] = null;

//Set params
foreach ($opts as $param) {
    //for showing help, exit afterwards without doing anything
    if ($param[0] == '?') {
        grdd_usage($console);
        exit();
    }
    else {
        $params[$param[0]] = $param[1];
    }
}

if ($params['d'] == null) {
    $params['d'] = $params['s'];
}

if (count($noneOpts) < 1) {
    grdd_usage($console);
    exit();
}


require_once('../libs/class.classLoader.php');
require_once('../libs/generator/class.restDdGenerator.php');
$searchPath = $noneOpts[0];
if (isset($noneOpts[1])) {
    $ddPath = $noneOpts[1];
}
else {
    $ddPath = $noneOpts[0];
}

if (!file_exists(realpath($searchPath)) or !file_exists(realpath($ddPath))) {
    if (!file_exists(realpath($searchPath))) {
        $console->writeLn('Search-Path doesn\'t exist!');
    }
    else {
        $console->writeLn('DD-Path doesn\'t exist!');
    }
    exit();
}

$console->writeLn('Base-Path:    '.realpath($searchPath));
$console->writeLn('Deploy-Path:  '.realpath($ddPath));
$console->writeLn();

$classes = get_declared_classes();
//last param should be the path to parse
ClassLoader::loadDir($searchPath);
$classes = array_diff(get_declared_classes(), $classes);

$generator = new RestDeploymentDescriptorGenerator($classes);
if ($params['a'] == null) {
    $generator->useAuthentication(false);
}
else {
    $generator->useAuthentication(true, 'digest', $params['a']);
}

if ($params['s'] != null) {
    $generator->setStandardSerializer($params['s']);
}

if ($params['d'] != null) {
    $generator->setStandardDeserializer($params['d']);
}

if ($params['f'] != null) {
    $mapping = parseFormatMap($params['f']);
    $generator->setFormatMapping($mapping);
}

if ($params['b'] != null) {
    $generator->setBaseUri($params['b']);
}

$generator->collectRestMethods();
$webClasses = $generator->getWebClasses();
$console->writeLn('Found classes:');
foreach ($classes as $class) {
    if (in_array($class, $webClasses)) {
        $console->writeLn('[web]  '.$class);
    }
    else {
        $console->writeLn('       '.$class);
    }

}

$console->writeLn('Create DD: '.$generator->getDeployFileName());
$generator->save($ddPath);
$console->writeLn('Copy REST Server: '.$ddPath.DIRECTORY_SEPARATOR.'rest.php');
copy(dirname(__FILE__).'/../libs/Server/rest.php', $ddPath.'/rest.php');
$console->writeLn('Deployment successful completed');

//=========================================================================
/**
 * Parses the given string as format map param and returns the mapping 
 * table
 *
 * @param string $str
 * @return array<string,string>
 */
function parseFormatMap($str) {
    $map = array();
    $pattern = '/([A-z0-9]+)=([A-z0-9]+)(?:;(.*))?/';
    while (preg_match($pattern, $str, $matches)) {
    	$map[$matches[1]] = $matches[2];
    	$str = (isset($matches[3]))?$matches[3]:'';
    }
    return $map;
}

//=========================================================================
/**
 * @param Console $console
 */
function grdd_usage($console) {
    $console->writeLn('Usage: '.$_SERVER['argv'][0].' [options] <base-path> [deploy-path]');
    $console->writeLn($_SERVER['argv'][0].' is meant to generate your'.
                        ' deployment descriptor for the REST server');
    $console->writeLn();
    $console->writeLn('  <base-path>   - path for searching for @restservice classes');
    $console->writeLn('  [deploy-path] - path to write deployment descriptor and rest server, defaults to <base-path>');
    $console->writeLn();
    $console->writeLn('  OPTIONS:');
    $console->writeLn('     -a <provider>    use digest authentication with given provider class');
    $console->writeLn('     -s <serializer>  use serializer class, default=PearSerializer');
    $console->writeLn('     -d <deserial>    use deserializer class, defaults to -s');
    $console->writeLn('     -f <formatmap>   to enable different serializations by &f URL-param');
    $console->writeLn('                      <formatmap> = ([A-z0-9]+)=([A-z0-9]+)(;([A-z0-9]+)=([A-z0-9]+))*');
    $console->writeLn('                      with $1 := <id> and $2 := <serializer class name>');
    $console->writeLn('     -t               do a testrun, don\'t deploy to path');
    $console->writeLn('     -b <rest-base>   base uri for the rest server (add /rest.php or change for mod_rewrite)');
    $console->writeLn('     -?               this help');
}
?>