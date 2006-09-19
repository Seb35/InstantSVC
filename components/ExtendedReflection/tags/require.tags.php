<?php
$path = dirname(realpath(__FILE__)).DIRECTORY_SEPARATOR;

require_once($path.'../class.TypeMapper.php');

require_once($path.'class.PHPDocParamTag.php');
require_once($path.'class.PHPDocReturnTag.php');
require_once($path.'class.PHPDocVarTag.php');

require_once($path.'class.PHPDocWebMethodTag.php');
require_once($path.'class.PHPDocWebServiceTag.php');
require_once($path.'class.PHPDocRestMethodTag.php');
require_once($path.'class.PHPDocRestInTag.php');
require_once($path.'class.PHPDocRestOutTag.php');
?>