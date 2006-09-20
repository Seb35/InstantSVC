<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectioniscReflectionTypeMapperTest extends ezcTestCase
{
    public function testIsPrimitive() {
        $iscReflectionPrimitiveTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean');
        foreach ($iscReflectionPrimitiveTypes as $type) {
        	self::assertTrue(iscReflectionTypeMapper::getInstance()->isPrimitive($type));
        }

        $noneiscReflectionPrimitiveTypes = array('ReflectionClass', 'array', 'int[]',
                                    'string[]', 'NoneExistingClassFooBar');
        foreach ($noneiscReflectionPrimitiveTypes as $type) {
        	self::assertFalse(iscReflectionTypeMapper::getInstance()->isPrimitive($type));
        }
    }

    public function testIsArray() {
        $arrayDefs = array('array', 'string[]', 'bool[]', 'ReflectionClass[]',
                           'NoneExistingTypeFooBar[]');
        foreach ($arrayDefs as $type) {
        	self::assertTrue(iscReflectionTypeMapper::getInstance()->isArray($type));
        }

        $arrayDefs = array('array<int, string>', 'array<string, ReflectionClass>',
                           'array<ReflectionClass, float>');
        foreach ($arrayDefs as $type) {
        	self::assertTrue(iscReflectionTypeMapper::getInstance()->isArray($type));
        }

        $noneiscReflectionArrayTypes = array('integer', 'int', 'INT', 'float', 'double',
                                'string', 'bool', 'boolean', 'NoneExistingClassFooBar',
                                'ReflectionClass');
        foreach ($noneiscReflectionArrayTypes as $type) {
        	self::assertFalse(iscReflectionTypeMapper::getInstance()->isArray($type));
        }

    }

    /**
     * Test ez Style arrays
     */
    public function testIsArray2() {
        $arrayDefs = array('array(string=>float)', 'array( int => ReflectionClass )',
                           'array( string => array( int => ReflectionClass ) )');
        foreach ($arrayDefs as $type) {
        	self::assertTrue(iscReflectionTypeMapper::getInstance()->isArray($type));
        }
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcReflectioniscReflectionTypeMapperTest" );
    }
}
?>
