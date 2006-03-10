<html>
<head>
    <title>Example for Extended Reflection API Schema Geration</title>
</head>
<body>
<?php
//error_reporting(E_ALL|E_STRICT);
include_once('../../config/config.php');
include_once(ROOT_DIR.'libs/reflection/require.package.php');
include_once(ROOT_DIR.'sample/libs/teletask/class.Lecture.php');


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
}

testWithClass2('Lecture');
testWithClass2('Lecture[]');
testWithClass2('Lecture[][]');
?>
</body>
</html>