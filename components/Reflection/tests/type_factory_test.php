<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ExtendedReflection
 * @subpackage Tests
 */

class ezcExtendedReflectionTypeFactoryTest extends ezcTestCase
{
    /**
     * Test with primitive types
     */
    public function testGetTypePrimitive() {
        $primitiveTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean');
        $factory = new TypeFactoryImpl();
        foreach ($primitiveTypes as $prim) {
        	$type = $factory->getType($prim);
        	self::assertType('Type', $type);
            self::assertType('PrimitiveType', $type);
        }
    }

    /**
     * Test with array types
     */
    public function testGetTypeArray() {
        $arrays = array('array<int, string>', 'array<string, ReflectionClass>',
                        'array<ReflectionClass, float>');
        $factory = new TypeFactoryImpl();
        foreach ($arrays as $arr) {
            $type = $factory->getType($arr);
            self::assertType('Type', $type);
            self::assertType('ArrayType', $type);
        }
    }

    /**
     * Test with class types
     */
    public function testGetTypeClass() {
        $classes = array('ReflectionClass', 'NoneExistingClassFooBarr', 'ezcTestClass');
        $factory = new TypeFactoryImpl();
        foreach ($classes as $class) {
        	$type = $factory->getType($class);
        	self::assertType('Type', $type);
            self::assertType('ClassType', $type);
        }
    }


    public static function suite()
    {
         return new ezcTestSuite( "ezcExtendedReflectionTypeFactoryTest" );
    }
}
?>
