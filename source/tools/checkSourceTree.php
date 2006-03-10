#!/usr/bin/php5.1
<?php
/**
 * Console script to check includability of whole sourcetree
 * it's necessary to recognize duplicate classnames
 *
 * @package    tools
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */

error_reporting(E_ALL|E_STRICT);
require_once('../../libs/misc/class.console.php');
require_once('../libs/class.classLoader.php');

$console = new Console();

//look through the cmd line args to know what to do now

if (count($_SERVER['argv']) > 1) {
    for ($i = 1; $i < count($_SERVER['argv']); $i++) {
        switch ($_SERVER['argv'][$i]) {
            case '-?':
            case '-h':
            case '/?':
            case '/h': {
                grdd_usage($console);
                break;
            }
        }
    }

    $searchPath = $_SERVER['argv'][count($_SERVER['argv'])-1];

    $console->writeLn('Search-Path: '.realpath($searchPath));
    $console->writeLn();

    ClassLoader::setDebug(true);
    //last param should be the path to parse
    ClassLoader::loadDir($searchPath);
    $console->readLn();
}
else {
    grdd_usage($console);
}

/**
 * @param Console $console
 */
function grdd_usage($console) {
    $console->writeLn('Usage: '.$_SERVER['argv'][0].' [options] <search-path>');
    $console->writeLn($_SERVER['argv'][0].' is meant to test source tree'.
                        ' for dependency problems or parsing errors');
    $console->writeLn();
    $console->writeLn('  <search-path> - path for loading all php files');
    $console->writeLn();
    $console->writeLn('  OPTIONS:');
    $console->writeLn('     -?     this help');
}
?>