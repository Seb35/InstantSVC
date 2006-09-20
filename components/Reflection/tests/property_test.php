<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionPropertyTest extends ezcTestCase
{
    public function testGetType() {
        $method = new iscReflectionMethod('iscReflectionClass', 'isTagged');
        $params = $method->getParameters();
        $type = $params[0]->getType();
        self::assertType('iscReflectionPrimitiveType', $type);
        self::assertEquals('string', $type->toString());
    }

    public function testGetDeclaringClass() {
        $method = new iscReflectionMethod('iscReflectionClass', 'isTagged');
        $params = $method->getParameters();
        $class = $params[0]->getDeclaringClass();
        self::assertType('iscReflectionClassType', $class);
        self::assertEquals('iscReflectionClass', $class->toString());
    }


    public static function suite()
    {
         return new ezcTestSuite( "ezcReflectionPropertyTest" );
    }
}
?>