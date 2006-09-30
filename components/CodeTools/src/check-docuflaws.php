#!/usr/bin/php5.1
<?php
/**
 * @todo use ezcConsoleInput
 */
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Console script to check for documentation flaws in definied classes   **
//**                                                                       **
//** @package    tools		                                             **
//** @author     Stefan Marr <mail@stefan-marr.de>				   **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//init ezComponents autoload
require_once('ezc/Base/base.php');
function __autoload( $className ) { ezcBase::autoload( $className ); }

if (!isset($_SERVER['argv'][1])) {
    echo 'Usage: checkDocuFlaws <SOURCE_FOLDER> [-w] [-wm]'."\n";
    echo '         -w    only webservices will be listed'."\n";
    echo '         -wm   only web- and rest-methods will be listed';
    return;
}
else {
    $path = $_SERVER['argv'][1];
    $webservices = ((isset($_SERVER['argv'][2]) and $_SERVER['argv'][2]=='-w')
                    or (isset($_SERVER['argv'][3]) and $_SERVER['argv'][3]=='-w'));
    $webmethods = ((isset($_SERVER['argv'][2]) and $_SERVER['argv'][2]=='-wm')
                    or (isset($_SERVER['argv'][3]) and $_SERVER['argv'][3]=='-wm'));
}

$stats = new iscCodeAnalyzer($path);
$stats->collect();
$flaws = $stats->getCodeSummary();
$flaws = $flaws['classes'];

foreach ($flaws as $classname => $class) {
    if ($class['webservice'] or !$webservices) {
        echo "Web Service Class: $classname\n";
        echo '  Missing Method Comments: #'.$class['missingMethodComments']."\n";
        echo '  Missing Param Types:     #'.$class['missingParamTypes']."\n";

        echo "\n  Methods\n";
        $i = 0;
        foreach ($class['methods'] as $methodName => $method) {
            if ($method['isInherited']) {
                continue;
            }
            if ($method['webmethod'] or $method['restmethod'] or !$webmethods) {
                if ($method['LoDB'] < 1 or $method['paramflaws'] > 0) {
                    echo "  $classname"."->$methodName()\n";
                    if ($method['LoDB'] < 1) {echo "      - comment missing\n";}
                    if ($method['paramflaws']>0) {echo "      - params not documented\n";}
                    $i++;
                }
            }
        }
        if ($i == 0) {echo "    no critical flaws found\n";}
        echo "\n";
    }
}

?>