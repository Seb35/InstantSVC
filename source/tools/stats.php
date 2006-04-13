#!/usr/bin/php5.1
<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Script to generate statistics							   **
//**                                                                       **
//** This script uses the CodeAnalyser to extract informations about used  **
//** comments and is intended to provied a visual feedback for flaws 	   **
//** within the documentation in terms of correctnes for generate		   ** 
//** a webservice from it.                                                 **
//** @package    tools		                                             **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************

//***** imports *************************************************************
include_once('../../libs/misc/class.codeAnalyzer.php');


define('CODE_PATH', realpath(dirname(__FILE__).'/../'));

$getcwd = getcwd();
error_reporting(E_ALL);

$declaredClasses = get_declared_classes();

$cli = (strpos(php_sapi_name(), 'cli') !== false);

$searchPath = null;

if (isset($_ENV['OS']) and stripos($_ENV['OS'], 'windows') !== false) {
    if (isset($_SERVER['argv'][1])) {
        $phpbin = $_SERVER['argv'][1];

        if ($cli and isset($_SERVER['argv'][2])) {
            $searchPath = $_SERVER['argv'][2];
        }
    }
    elseif (isset($_SERVER['PHP_PEAR_PHP_BIN'])) {
        $phpbin = $_SERVER['PHP_PEAR_PHP_BIN'].' -c '.$_SERVER['PHP_PEAR_PHP_BIN'];
    }
    else {
        $phpbin = 'c:\Programme\php5\php.exe -c c:\Programme\php5';
    }
}
else {
    $phpbin = '/usr/bin/php5.1';
    if ($cli and isset($_SERVER['argv'][1])) {
        $searchPath = $_SERVER['argv'][1];
    }
}

if (!$cli and isset($_REQUEST['searchpath'])) {
    $searchPath = $_REQUEST['searchpath'];
}


if ($searchPath != null) {
    $stats = new CodeAnalyzer($searchPath);
    $stats->setDeclaredClasses($declaredClasses);
    $stats->collect();
    $stats->setPhpBinPath($phpbin);
    echo "check docu flaws...\n";
    $stats->inspectFiles();
    echo "save docu...\n";

    chdir($getcwd);
    $stats->save('test.html');
}
else {
    if ($cli) {
        echo 'Usage: stats.php <searchpath>'."\n";
    }
    else {
        echo '<html><head><title>Stats Tool</title><body>';
        echo '<h1>Stats Tool</h1>';
        echo '<form>';
        echo 'Search Path: <input type="text" name="searchpath" />';
        echo '<input type="submit" />';
        echo '</form>';
        echo '</body></html>';
    }
}
?>