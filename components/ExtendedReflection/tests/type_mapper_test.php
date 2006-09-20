<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ExtendedReflection
 * @subpackage Tests
 */

class ezcExtendedReflectionTypeMapperTest extends ezcTestCase
{
    public function testIsPrimitive() {
        $primitiveTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean');
        foreach ($primitiveTypes as $type) {
        	self::assertTrue(TypeMapper::getInstance()->isPrimitive($type));
        }

        $nonePrimitiveTypes = array('ReflectionClass', 'array', 'int[]',
                                    'string[]', 'NoneExistingClassFooBar');
        foreach ($nonePrimitiveTypes as $type) {
        	self::assertFalse(TypeMapper::getInstance()->isPrimitive($type));
        }
    }

    public function testIsArray() {
        $arrayDefs = array('array', 'string[]', 'bool[]', 'ReflectionClass[]',
                           'NoneExistingTypeFooBar[]');
        foreach ($arrayDefs as $type) {
        	self::assertTrue(TypeMapper::getInstance()->isArray($type));
        }

        $arrayDefs = array('array<int, string>', 'array<string, ReflectionClass>',
                           'array<ReflectionClass, float>');
        foreach ($arrayDefs as $type) {
        	self::assertTrue(TypeMapper::getInstance()->isArray($type));
        }

        $noneArrayTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean', 'NoneExistingClassFooBar',
                                'ReflectionClass');
        foreach ($noneArrayTypes as $type) {
        	self::assertFalse(TypeMapper::getInstance()->isArray($type));
        }

    }

    /**
     * Test ez Style arrays
     */
    public function testIsArray2() {
        $arrayDefs = array('array(string=>float)', 'array( int => ReflectionClass )',
                           'array( string => array( int => ReflectionClass ) )');
        foreach ($arrayDefs as $type) {
        	self::assertTrue(TypeMapper::getInstance()->isArray($type));
        }
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcExtendedReflectionTypeMapperTest" );
    }
}
?>
