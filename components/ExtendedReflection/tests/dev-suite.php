<?php
error_reporting(E_ALL | E_STRICT);

require_once 'ezc/Base/base.php';
//ezcBase::addClassRepository('ezc/UnitTest');
function __autoload( $className ) { ezcBase::autoload( $className ); }

//require_once '../../UnitTest/src/test/runner.php';
//require_once '../../UnitTest/src/test/case.php';
//require_once '../../UnitTest/src/test/suite.php';

require_once '../src/extended_reflection.php';
require_once '../src/class.php';
require_once '../src/method.php';
require_once '../src/extension.php';
require_once '../src/phpdoc/parser.php';
require_once '../src/phpdoc/tag_factory.php';
require_once '../src/phpdoc/tag.php';
require_once '../src/interfaces/type.php';
require_once '../src/types/class_type.php';


include('suite.php');
?>