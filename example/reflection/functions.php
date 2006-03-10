<html>
<head>
    <title>Example for Extended Reflection API</title>
</head>
<body>
<?php
//error_reporting(E_ALL|E_STRICT);
include_once(dirname(__FILE__).'/../../libs/reflection/class.ExtReflectionFunction.php');
//include_once(dirname(__FILE__).'/../../sample/libs/teletask/class.Lecture.php');

/**
 * Enter description here...
 *
 * @param string $name
 * @return void
 */
function testFunction($name) {
    $method = new ExtReflectionFunction($name);
    echo '<h1>Function '.$method->getName().'</h1>';

    echo '<tt> function ';
       echo $method->getName();

        echo '(';
        $params = $method->getParameters();
        $str = '';
        foreach ($params as $param) {
            if ($str != '') {
                $str .= ', ';
            }
            if ($param->getType() == null) {
                $str .= $param->getName().': unknown';
            }
            else {
        	   $str .= $param->getName().':'.
        	           htmlspecialchars($param->getType()->toString());
            }
        }
        echo $str;
        if ($method->getReturnType() == null) {
            echo ') : unknown';
        }
        else {
            echo ') : '.htmlspecialchars($method->getReturnType()->toString());
        }
        echo '</tt>';
}

$functs = get_defined_functions();
foreach ($functs['user'] as $funcName) {


	testFunction($funcName);
}
?>
</body>
</html>