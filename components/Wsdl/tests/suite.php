<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Wsdl
 * @subpackage Tests
 */

/**
 * Require the test cases
 */
require_once 'wsdl_test.php';

/**
 * @package Wsdl
 * @subpackage Tests
 */
class iscWsdlSuite extends PHPUnit_Framework_TestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName('Wsdl');

        $this->addTest( iscWsdlTest::suite() );
    }
    
	protected function tearDown()
    {
        /*$this->deleteFiles(glob('./*.log', GLOB_BRACE));
        $this->deleteFiles(glob('./*.exp', GLOB_BRACE));
        $this->deleteFiles(glob('./*.out', GLOB_BRACE));
        $this->deleteFiles(glob('./*.diff', GLOB_BRACE));*/
    }
    
    protected function deleteFiles($files)
    {
    	foreach ($files as $file)
    		unlink($file);
    }

    public static function suite()
    {
        return new self();
    }
}
?>
