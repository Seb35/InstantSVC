<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionMethodTest extends ezcTestCase
{
    public function testGetDeclaringClass() {
        $method = new iscReflectionMethod('TestMethods', 'm1');
        $class = $method->getDeclaringClass();
        self::assertType('iscReflectionClassType', $class);
        self::assertEquals('TestMethods', $class->getName());
    }

    public function testIsMagic() {
        $method = new iscReflectionMethod('TestMethods', 'm1');
        self::assertFalse($method->isMagic());

        $class = $method->getDeclaringClass();
        self::assertTrue($class->getConstructor()->isMagic());
    }

    public function testGetTags() {
        $class = new iscReflectionClass('iscReflectionClass');
        $method = $class->getMethod('getMethod');
        $tags = $method->getTags();
        self::assertEquals(2, count($tags));


        $method = new iscReflectionMethod('TestMethods', 'm4');
        $tags = $method->getTags();
        $expectedTags = array('webmethod', 'author', 'param', 'param', 'param', 'return');
        ReflectionTestHelper::expectedTags($expectedTags, $tags, $this);

        $tags = $method->getTags('param');
        $expectedTags = array('param', 'param', 'param');
        ReflectionTestHelper::expectedTags($expectedTags, $tags, $this);

        $method = new iscReflectionMethod('TestMethods', 'm1');
        $tags = $method->getTags();
        $expectedTags = array('param', 'author');
        ReflectionTestHelper::expectedTags($expectedTags, $tags, $this);
    }

    public function testIsTagged() {
        $method = new iscReflectionMethod('TestMethods', 'm4');
        self::assertTrue($method->isTagged('webmethod'));
        self::assertFalse($method->isTagged('fooobaaar'));
    }

    public function testGetLongDescription() {
        $method = new iscReflectionMethod('TestMethods', 'm3');
        $desc = $method->getLongDescription();

        $expected = "This is the long description with may be additional infos and much more lines\nof text.\n\nEmpty lines are valide to.\n\nfoo bar";
        self::assertEquals($expected, $desc);
    }

    public function testGetShortDescription() {
        $method = new iscReflectionMethod('TestMethods', 'm3');
        $desc = $method->getShortDescription();

        $expected = "This is the short description";
        self::assertEquals($expected, $desc);
    }

    public function testIsWebmethod() {
        $method = new iscReflectionMethod('TestMethods', 'm3');
        self::assertFalse($method->isWebmethod());
        $method = new iscReflectionMethod('TestMethods', 'm4');
        self::assertTrue($method->isWebmethod());
    }

    public function testGetReturnDescription() {
        $method = new iscReflectionMethod('TestMethods', 'm4');
        $desc = $method->getReturnDescription();
        self::assertEquals('Hello World', $desc);
    }

    public function testGetReturnType() {
        $method = new iscReflectionMethod('TestMethods', 'm4');
        $type = $method->getReturnType();
        self::assertType('iscReflectionType', $type);
        self::assertEquals('string', $type->toString());
    }

    public function testGetParameters() {
        $method = new iscReflectionMethod('iscReflectionMethod', 'getTags');
        $params = $method->getParameters();

        $expectedParams = array('name');
        foreach ($params as $param) {
            self::assertType('iscReflectionParameter', $param);
            self::assertContains($param->getName(), $expectedParams);

            ReflectionTestHelper::deleteFromArray($param->getName(), $expectedParams);
        }
        self::assertEquals(0, count($expectedParams));
    }

    public function testIsInherited() {
        $method = new iscReflectionMethod('TestMethods2', 'm2');
        self::assertTrue($method->isInherited(new ReflectionClass('TestMethods2')));

        $method = new iscReflectionMethod('ReflectionMethod', 'isInternal');
        self::assertTrue($method->isInherited(new ReflectionClass('ReflectionMethod')));

        $method = new iscReflectionMethod('TestMethods2', 'newMethod');
        self::assertFalse($method->isInherited(new ReflectionClass('TestMethods2')));

        $method = new iscReflectionMethod('iscReflectionMethod', 'isInherited');
        self::assertFalse($method->isInherited(new ReflectionClass('iscReflectionMethod')));
    }

    public function testIsOverriden() {
        $method = new iscReflectionMethod('TestMethods2', 'm2');
        self::assertTrue($method->isOverriden(new ReflectionClass('TestMethods2')));

        $method = new iscReflectionMethod('TestMethods2', 'newMethod');
        self::assertTrue($method->isOverriden(new ReflectionClass('TestMethods2')));

        $method = new iscReflectionMethod('TestMethods2', 'm4');
        self::assertFalse($method->isOverriden(new ReflectionClass('TestMethods2')));

        $method = new iscReflectionMethod('iscReflectionMethod', 'isInternal');
        self::assertFalse($method->isOverriden(new ReflectionClass('iscReflectionMethod')));
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcReflectionMethodTest" );
    }
}
?>
