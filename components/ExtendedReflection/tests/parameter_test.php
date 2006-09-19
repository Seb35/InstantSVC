<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ExtendedReflection
 * @subpackage Tests
 */

class ezcExtendedReflectionParameterTest extends ezcTestCase
{
    public function testGetType() {
        $func = new ExtReflectionFunction('m1');
        $params = $func->getParameters();
        $type = $params[0]->getType();
        self::assertType('Type', $type);
        self::assertEquals('test', $params[0]->getName());
        self::assertEquals('string', $type->toString());

        $method = new ExtReflectionMethod('TestMethods', 'm3');
        $params = $method->getParameters();
        self::assertNull($params[0]->getType());
    }

    public function testGetClass() {
        $func = new ExtReflectionFunction('m1');
        $params = $func->getParameters();

        $type = $params[1]->getClass();
        self::assertType('Type', $type);
        self::assertEquals('test2', $params[1]->getName());
        self::assertEquals('ExtendedReflectionApi', $type->toString());

        //none existing type??
        //@TODO: fix this error
        //fix or change documentation of handling of not existing classes
        //with type system
        $type = $params[2]->getClass();
        self::assertType('Type', $type);
        self::assertEquals('test3', $params[2]->getName());
        self::assertEquals('NoneExistingType', $type->toString());

        $method = new ExtReflectionMethod('TestMethods', 'm3');
        $params = $method->getParameters();

        self::assertNull($params[0]->getClass());
    }

    public function testGetDeclaringFunction() {
        $func = new ExtReflectionFunction('m1');
        $params = $func->getParameters();
        //$decFunc = $params[0]->getDeclaringFunction();

        //TODO: implement, why is this function is missing on win32 5.1.5??
        self::markTestSkipped();
    }

    public function testGetDeclaringClass() {
        $method = new ExtReflectionMethod('TestMethods', 'm3');
        $params = $method->getParameters();

        //$params[0]->getDeclaringClass();
        //TODO: implement, why is this function is missing on win32 5.1.5??
        self::markTestSkipped();
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcExtendedReflectionParameterTest" );
    }
}
?>
