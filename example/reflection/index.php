<html>
<head>
    <title>Example for Extended Reflection API</title>
</head>
<body>
<?php
//error_reporting(E_ALL|E_STRICT);
include_once(dirname(__FILE__).'/../../libs/reflection/class.ExtReflectionClass.php');
//include_once(dirname(__FILE__).'/../../sample/libs/teletask/class.Lecture.php');


function testWithClass($name) {
    $class = new ExtReflectionClass($name);

    echo '<h1>'.$class->getName().'</h1>';

    $parent = $class->getParentClass();
    if ($parent != null) {
        echo '<h3>extends '.$parent->getName().'</h3>';
    }

    $interfaces = $class->getInterfaces();

    if (count($interfaces) > 0) {
        echo '<h3>implements</h3><ul>';
        foreach ($interfaces as $interface) {
        	echo '<li>'.$interface->getName().'</li>';
        }
        echo '</ul>';
    }


    echo '<h2>Properties and Methods</h2>';

    $properties = $class->getProperties();

    echo '<ul>';
    foreach ($properties as $prop) {
        echo '<li>';
        echo '<strong>';
        echo ($prop->isPublic() ? ' public' : '').
             ($prop->isPrivate() ? ' private' : '').
             ($prop->isProtected() ? ' protected' : '').
             ($prop->isStatic() ? ' static' : '');
        echo '</strong> ';
        echo $prop->getName();
        if ($prop->getType() == null) {
            echo ' : unknown';
        }
        else {
            echo ' : '.htmlspecialchars($prop->getType()->toString());
        }
        echo '</li>';
    }
    echo '</ul>';

    $methodes = $class->getMethods();

    echo '<ul>';
    foreach ($methodes as $method) {
        echo '<li>';
        echo '<strong>';
        echo ($method->isPublic() ? ' public' : '').
             ($method->isPrivate() ? ' private' : '').
             ($method->isProtected() ? ' protected' : '').
             ($method->isStatic() ? ' static' : '');
        echo '</strong> ';
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
        echo '</li>';
    }
    echo '</ul>';
}
//testWithClass('Lecture');
testWithClass('ExtReflectionClass');
testWithClass('ExtReflectionProperty');
testWithClass('PHPDocParamTag');
testWithClass('PHPDocParser');
testWithClass('PHPDocTag');
testWithClass('PHPDocTagFactory');
testWithClass('Reflector');
testWithClass('Reflection');
testWithClass('ReflectionClass');
testWithClass('ReflectionFunction');
testWithClass('ReflectionMethod');
testWithClass('ReflectionParameter');
testWithClass('ReflectionException');
testWithClass('ReflectionObject');
?>
</body>
</html>