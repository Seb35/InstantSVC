<html>
<head>
    <title>Example for Extended Reflection API Schema Geration</title>
</head>
<body>
<?php
//error_reporting(E_ALL|E_STRICT);
include_once(dirname(__FILE__).'/../../libs/reflection/class.ExtendedReflectionApi.php');
include_once(dirname(__FILE__).'/../teletask/libs/class.Lecture.php');

//=======================================================================
/**
* @param string $name
*/
function testWithClass2($name) {
    $dom = new DOMDocument();
    $dom->formatOutput = true;
    $type = ExtendedReflectionApi::getInstance()->getTypeByName($name);

    echo '<h1>'.$type->toString().'</h1>';
    echo '<h2>XML Schema</h2>';

    echo '<pre>';

    $parent = $type->getXmlSchema($dom);
    $dom->appendChild($parent);
    echo htmlentities($dom->saveXML());

    echo '</pre>';
} //end testWithClass2

testWithClass2('Lecture');
testWithClass2('Lecture[]');
testWithClass2('Lecture[][]');
?>
</body>
</html>