<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ExtendedReflection
 * @subpackage Tests
 */

class ezcExtendedReflectionPropertyTest extends ezcTestCase
{
    public function testGetType() {
        $method = new ExtReflectionMethod('ExtReflectionClass', 'isTagged');
        $params = $method->getParameters();
        $type = $params[0]->getType();
        self::assertType('PrimitiveType', $type);
        self::assertEquals('string', $type->toString());
    }

    public function testGetDeclaringClass() {
        $method = new ExtReflectionMethod('ExtReflectionClass', 'isTagged');
        $params = $method->getParameters();
        $class = $params[0]->getDeclaringClass();
        self::assertType('ClassType', $class);
        self::assertEquals('ExtReflectionClass', $class->toString());
    }


    public static function suite()
    {
         return new ezcTestSuite( "ezcExtendedReflectionPropertyTest" );
    }
}
?>