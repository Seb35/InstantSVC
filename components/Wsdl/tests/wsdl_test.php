<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package CodeAnalyzer
 * @subpackage Tests
 */

class iscWsdlTest extends ezcTestCase
{
	/**
	 * This test case is only used to ensure basic functionality and 
	 * a working interface for generating a wsdl and return it as string
	 */
    public function testBasics() {
    	require_once(dirname(__FILE__).'/testclasses/hello_world.php');
        $wgen = new iscWsdlGenerator('HelloWorld',
        							  'http://localhost/Hello',
        							  'urn:HelloWorld',
        							  iscWsdlGenerator::DOCUMENT_WRAPPED);
        $wgen->setTypeNamespace('urn:HelloWorld/types');
        $wgen->setClass('HelloWorld');
        $wsdl = $wgen->getString();
    	
        self::assertTrue(strpos($wsdl, 'operation') !== false);
        self::assertTrue(strpos($wsdl, 'tns:sayHelloOut') !== false);
        self::assertTrue(strpos($wsdl, 'HelloWorldPort') !== false);
    }
    
    public function testUsingPhpTest() 
    {
    	error_reporting(2047);
	    require_once 'PEAR/RunTest.php';
	
	    $testRunner = new PEAR_RunTest(null, array('simple' => true));
	    $testCases = array();
	
	    $testCases = glob('./*.phpt', GLOB_BRACE);  
	    $testCases = array_merge($testCases, glob('./soap_interop_tests/Round2/Base/*.phpt', GLOB_BRACE));  
	    $testCases = array_merge($testCases, glob('./soap_interop_tests/Round4/GroupI/*.phpt', GLOB_BRACE));  

	    $failedTests = array();
	    if (!empty($testCases)) {
	        foreach ($testCases as $testCase) {
	        	ob_start();
	            $result = $testRunner->run($testCase);
	            $msg = ob_get_clean();
	            if ($result === 'FAILED')
	            {
	            	$failedTests[] = $msg;
	            }
	        }
	    }
	    self::assertEquals(array(), $failedTests);
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>