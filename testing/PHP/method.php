<?php
require_once('ezc/Base/base.php');
function __autoload( $className ) { ezcBase::autoload( $className ); }

$method = new iscReflectionMethod('ezcConfigurationIniItem', '__set');
var_dump($method->getFileName());
var_dump($method->getStartLine());
var_dump($method->getDocComment());

$method = new iscReflectionMethod('iscReflectionMethod', 'getDocComment');
var_dump($method->getFileName());
var_dump($method->getStartLine());
var_dump($method->getDocComment());
?>