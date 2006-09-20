<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ExtendedReflection
 * @subpackage Tests
 */

class ezcExtendedReflectionExtensionTest extends ezcTestCase
{
    public function testGetFunctions() {
        $ext = new ExtReflectionExtension('Spl');
        $functs = $ext->getFunctions();
        foreach ($functs as $func) {
            self::assertType('ExtReflectionFunction', $func);
        }

        $ext = new ExtReflectionExtension('Reflection');
        $functs = $ext->getFunctions();
        self::assertEquals(0, count($functs));
    }

    public function testGetClasses() {
        $ext = new ExtReflectionExtension('Reflection');
        $classes = $ext->getClasses();

        foreach ($classes as $class) {
            self::assertType('ClassType', $class);
        }
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcExtendedReflectionExtensionTest" );
    }
}
?>
