#!/usr/bin/php5.1
<?php
//init ezComponents autoload
require_once('ezc/Base/base.php');
function __autoload( $className ) { ezcBase::autoload( $className ); }

$input = new ezcConsoleInput();

$out = new ezcConsoleOutput();
$out->formats->keyword->style = array('bold');

//disable formats on win32. cmd.exe doesn't because of missing ANSI support cmd.exe
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
    $out->outputText($input->getHelpText('Colects stats and metrics '.
                     'for a given source tree or file.'));
}
else {
    $files = $args[0];

    if (is_dir($files) && is_readable($files)) {
        $analyzer = new iscCodeAnalyzer($files);
        $analyzer->collect();
        $sum = $analyzer->getCodeSummary();
        $stats = $analyzer->getStats();
        $overall['linesOfCode'] = 0;
    	$overall['fileSize'] = 0;
    	$overall['countClasses'] = 0;
    	$overall['countInterfaces'] = 0;
    	$overall['countFunctions'] = 0;

        foreach ($stats as $file) {
        	$overall['linesOfCode']     += $file->linesOfCode;
        	$overall['fileSize']        += $file->fileSize;
        	$overall['countClasses']    += $file->countClasses;
        	$overall['countInterfaces'] += $file->countInterfaces;
        	$overall['countFunctions']  += $file->countFunctions;
        }
    }
    elseif (is_file($files) && is_readable($files)) {
        $sum = iscCodeAnalyzer::summarizeFile($files);
    }

    $sourcePath = realpath($files);
    $files = $sum;

    ob_start();
    include(dirname(__FILE__).'/tpls/codestats.tpl');
    $result = ob_get_clean();

    if (isset($args[1])) {
        file_put_contents($args[1], $result);
    }
    else {
        echo $result;
    }
}

?>