<?php
    /* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

    echo 'Note: The test cases do NOT delete the generated WSDL files.' . "\n";

    require_once 'PEAR/RunTest.php';

    $t = new PEAR_RunTest(null, array('simple' => true));
    $testCases = array();

    $testCases = glob('./*.phpt', GLOB_BRACE);  
    $testCases = array_merge($testCases, glob('./soap_interop_tests/Round2/Base/*.phpt', GLOB_BRACE));  
    $testCases = array_merge($testCases, glob('./soap_interop_tests/Round4/GroupI/*.phpt', GLOB_BRACE));  

    if (!empty($testCases)) {
        foreach ($testCases as $testCase) {
            //echo $testCase . "\n";
            $o = $t->run($testCase);
        }
    }
?>
