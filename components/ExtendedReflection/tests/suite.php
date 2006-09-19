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
require_once 'extended_reflection_test.php';
require_once 'function_test.php';
require_once 'parameter_test.php';
require_once 'class_test.php';
require_once 'method_test.php';
require_once 'property_test.php';
require_once 'extension_test.php';
require_once 'type_factory_test.php';
require_once 'type_mapper_test.php';
require_once 'parser_test.php';
require_once 'tag_factory_test.php';

/** Test Subjects */
require_once 'test_classes/webservice.php';
require_once 'test_classes/methods.php';

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

        $this->addTest( ezcExtendedReflectionTest::suite() );
        $this->addTest( ezcExtendedReflectionFunctionTest::suite() );
        $this->addTest( ezcExtendedReflectionParameterTest::suite() );
        $this->addTest( ezcExtendedReflectionClassTest::suite() );
        $this->addTest( ezcExtendedReflectionMethodTest::suite() );
        $this->addTest( ezcExtendedReflectionPropertyTest::suite() );
        $this->addTest( ezcExtendedReflectionExtensionTest::suite() );
        $this->addTest( ezcExtendedReflectionTypeFactoryTest::suite() );
        $this->addTest( ezcExtendedReflectionTypeMapperTest::suite() );
        $this->addTest( ezcExtendedReflectionPhpDocParserTest::suite() );
        $this->addTest( ezcExtendedReflectionPhpDocTagFactoryTest::suite() );
    }

    public static function suite()
    {
        return new self();
    }
}
?>
