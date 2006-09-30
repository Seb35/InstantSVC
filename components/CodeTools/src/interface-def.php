#!/usr/bin/php5.1
<?php
//require_once(dirname(__FILE__).'/../../../libs/misc/class.codeAnalyzer.php');

/*** EZC ***/
require_once('ezc/Base/base.php');
function __autoload( $className ) { ezcBase::autoload( $className ); }
/***********/

$input = new ezcConsoleInput();
//$input->registerOption(new ezcConsoleOption('f', 'file', ezcConsoleInput::TYPE_STRING, null, false, 'Source file to be analysed', 'The sourcefile to be analysed and to create the output'));

$out = new ezcConsoleOutput();
$out->formats->keyword->style = array('bold');
if (ezcSystemInfo::getInstance()->osType == 'win32') {
	$out->options->useFormats = false;
}
try {
    $input->process();
}
catch ( ezcConsoleOptionException $e )
{
        die( $e->getMessage() );
}

$args = $input->getArguments();
if (count($args) < 1) {
    $out->outputText($input->getHelpText('Generates an interface overview '.
                     'for a given file. All classes and functions inside '.
                     'these file will be printed like in the php.net '.
                     'documentation.'));
}
else {
    $analyzer = new CodeAnalyzer();
    $files = array(new FileDetails($args[0]));

    $analyzer->inspectFiles($files);
    $summary = $analyzer->getCodeSummary();
	//var_dump($files);
	//var_dump($summary);

    foreach ($summary['classes'] as $name => $class) {
        if (realpath($class['file']) == realpath($args[0])) {
            outputClass($name, $class);
        }
    }

    foreach ($summary['functions'] as $name => $function) {
        if ($function['file'] == $args[0]) {
            outputFunction($name, $function);
        }
    }
}

/**
 * @param string $name
 * @param array $class
 */
function outputClass($name, $class) {
    $mods = implode(' ', Reflection::getModifierNames($class['modifiers']));
    if (strlen($mods) > 0) {echo $mods.' ';}

    echo ($class['isFinal']) ? 'final ' : '';
    echo ($class['isInterface']) ? 'interface ' : 'class ';
    echo $name;
    if ($class['parentClass'] != null) {
        echo ' extends '.$class['parentClass'];
    }
    echo ' {'."\n";
    foreach ($class['methods'] as $mName => $method) {
        echo "\t";

        echo ($method['isAbstract']) ? 'abstract ' : '';
        echo ($method['isFinal']) ? 'final ' : '';
        echo ($method['isPublic']) ? 'public ' : '';
        echo ($method['isPrivate']) ? 'private ' : '';
        echo ($method['isProtected']) ? 'protected ' : '';
        echo ($method['isStatic']) ? 'static ' : '';
        echo ($method['return'] == null) ? 'void' : $method['return'];
        echo ' '.$mName.'(';
        $params = '';
        foreach ($method['params'] as $pName => $type) {
        	if ($params != '') { $params .= ', '; }
        	$params .= $type.' $'.$pName;
        }
        echo $params;
        echo ')'."\n";
    }
    echo '}'."\n";
}

/**
 * @param string $name
 * @param array $class
 */
function outputFunction($function) {
    var_dump($function);
}
?>