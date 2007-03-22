<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectioniscReflectionTypeFactoryTest extends ezcTestCase
{
    /**
     * Test with primitive types
     */
    public function testGetTypePrimitive() {
        $iscReflectionPrimitiveTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean');
        $factory = new iscReflectionTypeFactoryImpl();
        foreach ($iscReflectionPrimitiveTypes as $prim) {
        	$type = $factory->getType($prim);
        	self::assertType('iscReflectionType', $type);
            self::assertType('iscReflectionPrimitiveType', $type);
        }
    }

    /**
     * Test with array types
     */
    public function testGetTypeArray() {
        $arrays = array('array<int, string>', 'array<string, ReflectionClass>',
                        'array<ReflectionClass, float>');
        $factory = new iscReflectionTypeFactoryImpl();
        foreach ($arrays as $arr) {
            $type = $factory->getType($arr);
            self::assertType('iscReflectionType', $type);
            self::assertType('iscReflectionArrayType', $type);
        }
    }

    /**
     * Test with class types
     */
    public function testGetTypeClass() {
        $classes = array('ReflectionClass', 'NoneExistingClassFooBarr', 'ezcTestClass');
        $factory = new iscReflectionTypeFactoryImpl();
        foreach ($classes as $class) {
        	$type = $factory->getType($class);
        	self::assertType('iscReflectionType', $type);
            self::assertType('iscReflectionClassType', $type);
        }
    }


    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectioniscReflectionTypeFactoryTest" );
    }
}
?>
