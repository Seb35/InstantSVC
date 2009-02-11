#!/usr/bin/env php
<?php
//init ezComponents autoload
require_once dirname( __FILE__ ) . '/../../autoload-ezcomponents.php';

$input = new ezcConsoleInput();

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
    $path = $args[0];
    if (is_file($path)) {
        $analyzer = new iscCodeAnalyzer();
        $analyzer->inspectFiles(array($path));
    }
    elseif (is_dir($path)) {
        $analyzer = new iscCodeAnalyzer($path);
        $analyzer->collect();
    }

    $summary = $analyzer->getCodeSummary();

    $output = '';
    if (isset($args[1])) {
        ob_start();
    }

    foreach ($summary['classes'] as $name => $class) {
        outputClass($name, $class);
    }

    foreach ($summary['interfaces'] as $name => $inter) {
        outputClass($name, $inter);
    }

    foreach ($summary['functions'] as $name => $function) {
        outputFunction($name, $function);
    }

    if (isset($args[1])) {
        $output = ob_get_clean();
        file_put_contents($args[1], $output);
    }
}

/**
 * @param string $name
 * @param array $class
 */
function outputClass($name, $class) {
    //$mods = implode(' ', Reflection::getModifierNames($class['modifiers']));
    //if (strlen($mods) > 0) {echo $mods.' ';}
    $inter = $class['isInterface'];
    echo ($class['isFinal']) ? 'final ' : '';

    if ($inter) {
        echo 'interface ';
    }
    else {
        echo ($class['isAbstract']) ? 'abstract ' : '';
        echo 'class ';
    }

    echo $name;
    if ($class['parentClass'] != null) {
        echo ' extends '.$class['parentClass'];
    }

    if (count($class['interfaces']) > 0) {
        echo ' implements '.implode(', ', $class['interfaces']);
    }

    echo ' {'."\n";
    foreach ($class['methods'] as $mName => $method) {
        if ($method['isInherited']) {
            continue;
        }

        echo "\t";

        echo ($method['isAbstract'] and !$inter) ? 'abstract ' : '';
        echo ($method['isFinal'] and !$inter) ? 'final ' : '';
        echo ($method['isPublic'] and !$inter) ? 'public ' : '';
        echo ($method['isPrivate'] and !$inter) ? 'private ' : '';
        echo ($method['isProtected'] and !$inter) ? 'protected ' : '';
        echo ($method['isStatic']) ? 'static ' : '';
        echo ($method['return'] == null) ? 'void' : $method['return'];
        echo ' '.$mName.'(';
        $params = '';
        foreach ($method['params'] as $pName => $param) {
        	if ($params != '') { $params .= ', '; }
        	$params .= $param['type'].' $'.$pName;
        	if ($param['isOptional']) {
        	    $params .= ' = '.str_replace("\n", '', var_export($param['defaultValue'], true));
        	}

        }
        echo $params;
        echo ')'."\n";
    }
    echo '}'."\n";
}

/**
 * @param string $name
 * @param array $class
 * @todo implement
 */
function outputFunction($function) {
    var_dump($function);
}

?>
