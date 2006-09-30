<?php

/**
 * 1
 * Begin : Z3
 * 2
 * End : Z12
 * 3
 *
 * 4
 * 10 Zeilen Kommentar
 */
class Test {

    /**
     * Begin : Z15
     *
     *
     *
     *
     * 10 Zeilen Kommentar
     *
     * End : Z24
     */
    public function m1() {
        $ab = 0;
        $ab = 0;
        $ab = 0;
        $ab = 0;
        $ab = 0;
        $ab = 0;
        $ab = 0; //10 Zeilen Code
        $ab = 0;
        $ab = 0;
    }
}

$class = new ReflectionClass('Test');
$cLines = substr_count($class->getDocComment(), "\n");

echo "cLines: $cLines\n";
echo "Start:  ".$class->getStartLine()."\n";
echo "End:    ".$class->getEndLine()."\n";

$method = $class->getMethod('m1');
$cLines = substr_count($method->getDocComment(), "\n");

echo "cLines: $cLines\n";
echo "Start:  ".$method->getStartLine()."\n";
echo "End:    ".$method->getEndLine()."\n";

?>