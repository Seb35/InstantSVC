<?php
error_reporting(E_ALL | E_STRICT);

require_once 'ezc/Base/base.php';
function __autoload( $className ) { ezcBase::autoload( $className ); }

//require_once '../src/class_loader.php';
//require_once '../src/code_analyzer.php';
require_once '../src/file_details.php';

include('suite.php');
?>