#!/usr/bin/php5.1
<?php
/**
 * Console script to check for documentation flaws in definied classes
 *
 * @package    tools
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */


require_once('class.stats.php');
//at this point only buildin classes should be listed
$declaredClasses = get_declared_classes();

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


$stats = new Stats($path);
$stats->setDeclaredClasses($declaredClasses);
$stats->collect();
$stats->collectDocumentationFlaws();
$flaws = $stats->getDocuFlaws();

foreach ($flaws as $classname => $class) {
    if ($class['webservice'] or !$webservices) {
        echo "Web Service Class: $classname\n";
        echo '  Missing Method Comments: #'.$class['missingMethodComments']."\n";
        echo '  Missing Param Types:     #'.$class['missingParamTypes']."\n";

        echo "\n  Methods\n";
        $i = 0;
        foreach ($class['methods'] as $methodName => $method) {
            if ($method['webmethod'] or $method['restmethod'] or !$webmethods) {
                if (!$method['comment'] or $method['paramflaws']>0) {
                    echo "  $classname"."->$methodName()\n";
                    if (!$method['comment']) {echo "      - comment missing\n";}
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