<?php
error_reporting(E_ALL | E_STRICT);

require_once 'ezc/Base/base.php';

function __autoload( $className ) { ezcBase::autoload( $className ); }

require_once dirname(__FILE__).'/../src/interfaces/wsdl_generator_plugin.php';
require_once dirname(__FILE__).'/../src/wsdl_generator.php';
require_once dirname(__FILE__).'/../../Soap/src/adapter_generator.php';

include('suite.php');
?>