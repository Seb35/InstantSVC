<?php
class Test {
    static public function output($var) {
        if (is_string($var)) {
            $var = unserialize($var);
        }
        echo "\n\nTest::output()\n";
        var_dump($var);
        echo "\n\nend\n";
        exit(25);
    }
}
?>