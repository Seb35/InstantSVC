<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ExtendedReflection
 * @subpackage Tests
 */

/**
 * Require the test cases
 */
require_once 'class_test.php';
require_once 'test_classes/webservice.php';

/**
 * @package ExtendedReflection
 * @subpackage Tests
 */
class ezcExtendedReflectionSuite extends ezcTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName("ExtendedReflection");

        $this->addTest( ezcExtendedReflectionClassTest::suite() );
    }

    public static function suite()
    {
        return new self();
    }
}
?>
