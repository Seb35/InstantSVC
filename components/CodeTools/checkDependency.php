#!/usr/bin/php5.1
<?php

//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Console script to check whether all dependencies has been made        **
//** explicitly in every code file							   **
//** Script checks every .php file                                         **
//**  						                                 **
//**                                                                       **
//** @package    tools		                                             **
//** @author     Stefan Marr <mail@stefan-marr.de>				   **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

 //=========================================================================
 /**
  * Find all .php files in all subdirectory
  *
  * @param string $path
  * @return string[]
  */
 function findPhpFiles($path) {
    $files = array();
    if (is_dir($path)) {
        if ($dir = opendir($path)) {
            while (($file = readdir($dir)) !== false) {
                if ($file != '..' && $file != '.' && $file != '.svn' && $file != 'CVS') {
                    if (is_dir($path.'/'.$file)) {
                        $files = array_merge($files, findPhpFiles($path.'/'.$file));
                    }
                    else {
                        if (strripos($file, '.php') !== false)
                            $files[] = $path.'/'.$file;
                    }
                }
            }
            closedir($dir);
        }
    }
    return $files;
}

if (stripos($_ENV['OS'], 'windows') !== false) {
    //Test for params;
    if (!isset($_SERVER['argv'][1]) or !isset($_SERVER['argv'][2])) {
        echo 'Usage: checkDependency.bat <SOURCE_FOLDER>';
        return;
    }

    $phpbin = $_SERVER['argv'][1];
    $path = $_SERVER['argv'][2];
}
else {
    //Test for params;
    if (!isset($_SERVER['argv'][1])) {
        echo 'Usage: checkDependency.php <SOURCE_FOLDER>';
        return;
    }
    $phpbin = '/usr/bin/php5.1';
    $path = $_SERVER['argv'][1];
}

$files = findPhpFiles($path);

foreach ($files as $file) {
    ob_start();
    $cmd = $phpbin.' -r include(\''.$file.'\');';
    passthru($cmd);
    $out = ob_get_clean();

    if (strlen(trim($out)) > 0) {
        if (stripos($out, 'warning') !== false or stripos($out, 'fatal error')) {
            echo '::'.$file."\n";
            echo $out."\n";
            echo '--------------------------------------------------------------------------------'."\n";
        }
    }
}
?>