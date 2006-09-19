<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ExtendedReflection
 * @subpackage Tests
 */

class ezcExtendedReflectionMethodTest extends ezcTestCase
{
    public function testGetDeclaringClass() {
        $method = new ExtReflectionMethod('TestMethods', 'm1');
        $class = $method->getDeclaringClass();
        self::assertType('ClassType', $class);
        self::assertEquals('TestMethods', $class->getName());
    }

    public function testIsMagic() {
        $method = new ExtReflectionMethod('TestMethods', 'm1');
        self::assertFalse($method->isMagic());

        $class = $method->getDeclaringClass();
        self::assertTrue($class->getConstructor()->isMagic());
    }

    public function testGetTags() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        $method = $class->getMethod('getMethod');
        $tags = $method->getTags();
        self::assertEquals(2, count($tags));


        $method = new ExtReflectionMethod('TestMethods', 'm4');
        $tags = $method->getTags();
        $expectedTags = array('webmethod', 'author', 'param', 'param', 'param', 'return');
        ExtendedReflectionTestHelper::expectedTags($expectedTags, $tags, $this);

        $tags = $method->getTags('param');
        $expectedTags = array('param', 'param', 'param');
        ExtendedReflectionTestHelper::expectedTags($expectedTags, $tags, $this);

        $method = new ExtReflectionMethod('TestMethods', 'm1');
        $tags = $method->getTags();
        $expectedTags = array('param', 'author');
        ExtendedReflectionTestHelper::expectedTags($expectedTags, $tags, $this);
    }

    public function testIsTagged() {
        $method = new ExtReflectionMethod('TestMethods', 'm4');
        self::assertTrue($method->isTagged('webmethod'));
        self::assertFalse($method->isTagged('fooobaaar'));
    }

    public function testGetLongDescription() {
        $method = new ExtReflectionMethod('TestMethods', 'm3');
        $desc = $method->getLongDescription();

        $expected = "This is the long description with may be additional infos and much more lines\nof text.\n\nEmpty lines are valide to.\n\nfoo bar";
        self::assertEquals($expected, $desc);
    }

    public function testGetShortDescription() {
        $method = new ExtReflectionMethod('TestMethods', 'm3');
        $desc = $method->getShortDescription();

        $expected = "This is the short description";
        self::assertEquals($expected, $desc);
    }

    public function testIsWebmethod() {
        $method = new ExtReflectionMethod('TestMethods', 'm3');
        self::assertFalse($method->isWebmethod());
        $method = new ExtReflectionMethod('TestMethods', 'm4');
        self::assertTrue($method->isWebmethod());
    }

    public function testGetReturnDescription() {
        $method = new ExtReflectionMethod('TestMethods', 'm4');
        $desc = $method->getReturnDescription();
        self::assertEquals('Hello World', $desc);
    }

    public function testGetReturnType() {
        $method = new ExtReflectionMethod('TestMethods', 'm4');
        $type = $method->getReturnType();
        self::assertType('Type', $type);
        self::assertEquals('string', $type->toString());
    }

    public function testGetParameters() {
        $method = new ExtReflectionMethod('ExtReflectionMethod', 'getTags');
        $params = $method->getParameters();

        $expectedParams = array('name');
        foreach ($params as $param) {
            self::assertType('ExtReflectionParameter', $param);
            self::assertContains($param->getName(), $expectedParams);

            ExtendedReflectionTestHelper::deleteFromArray($param->getName(), $expectedParams);
        }
        self::assertEquals(0, count($expectedParams));
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcExtendedReflectionMethodTest" );
    }
}
?>
