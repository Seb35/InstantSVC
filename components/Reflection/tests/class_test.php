<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionClassTest extends ezcTestCase
{

    public function testGetMethod() {
        $class = new iscReflectionClass('iscReflectionClass');
        $method = $class->getMethod('getMethod');
        self::assertType('iscReflectionMethod', $method);
        self::assertEquals($method->getName(), 'getMethod');
    }


    public function testGetConstructor() {
        $class = new iscReflectionClass('iscReflectionClass');
        $method = $class->getConstructor();
        self::assertType('iscReflectionMethod', $method);
        self::assertEquals($method->getName(), '__construct');
    }


    public function testGetMethods() {
        $class = new iscReflectionClass('TestWebservice');
        $methods = $class->getMethods();
        self::assertEquals(0, count($methods));

        $class = new iscReflectionClass('TestMethods');
        $methods = $class->getMethods();

        $expectedMethods = array('__construct', 'm1', 'm2', 'm3', 'm4');
        foreach ($methods as $method) {
            self::assertType('iscReflectionMethod', $method);
            self::assertContains($method->getName(), $expectedMethods);

            ReflectionTestHelper::deleteFromArray($method->getName(), $expectedMethods);
        }
        self::assertEquals(0, count($expectedMethods));
    }

    public function testGetParentClass() {
        $class = new iscReflectionClass('iscReflectionClass');
        $parent = $class->getParentClass();

        self::assertType('ReflectionClass', $parent);
        self::assertEquals($parent->getName(), 'ReflectionClass');

        $parentParent = $parent->getParentClass();
        self::assertNull($parentParent);
    }

    public function testGetProperty() {
        $class = new iscReflectionClass('iscReflectionClass');
        $prop = $class->getProperty('docParser');

        self::assertType('iscReflectionProperty', $prop);
        self::assertEquals('docParser', $prop->getName());

        try {
            $prop = $class->getProperty('none-existing-property');
        }
        catch (ReflectionException $expected) {
            return;
        }
        $this->fail('ReflectionException has not been raised on none existing property.');
    }

    public function testGetProperties() {
        $class = new iscReflectionClass('TestWebservice');
        $properties = $class->getProperties();

        $expected = array('prop1', 'prop2', 'prop3');

        foreach ($properties as $prop) {
            self::assertType('iscReflectionProperty', $prop);
            self::assertContains($prop->getName(), $expected);

            ReflectionTestHelper::deleteFromArray($prop->getName(), $expected);
        }
        self::assertEquals(0, count($expected));
    }

    public function testIsWebService() {
        $class = new iscReflectionClass('iscReflectionClass');
        self::assertFalse($class->isWebService());

        $class = new iscReflectionClass('TestWebservice');
        self::assertTrue($class->isWebService());
    }

    public function testGetShortDescription() {
        $class = new iscReflectionClass('TestWebservice');
        $desc = $class->getShortDescription();

        self::assertEquals('This is the short description', $desc);
    }

    public function testGetLongDescription() {
        $class = new iscReflectionClass('TestWebservice');
        $desc = $class->getLongDescription();

        $expected = "This is the long description with may be additional infos and much more lines\nof text.\n\nEmpty lines are valide to.\n\nfoo bar";
        self::assertEquals($expected, $desc);
    }

    public function testIsTagged() {
        $class = new iscReflectionClass('iscReflectionClass');
        self::assertFalse($class->isTagged('foobar'));

        $class = new iscReflectionClass('TestWebservice');
        self::assertTrue($class->isTagged('foobar'));
    }



    public function testGetTags() {
        $class = new iscReflectionClass('iscReflectionClass');
        $tags = $class->getTags();

        $expectedTags = array('package', 'author', 'author', 'copyright',
                              'license');
        ReflectionTestHelper::expectedTags($expectedTags, $tags, $this);

        $expectedTags = array('webservice', 'foobar');
        $class = new iscReflectionClass('TestWebservice');
        $tags = $class->getTags();
        ReflectionTestHelper::expectedTags($expectedTags, $tags, $this);
    }

    public function testGetExtension() {
        $class = new iscReflectionClass('ReflectionClass');
        $ext = $class->getExtension();
        self::assertType('iscReflectionExtension', $ext);
        self::assertEquals($ext->getName(), 'Reflection');

        $class = new iscReflectionClass('TestWebservice');
        $ext = $class->getExtension();
        self::assertNull($ext);
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcReflectionClassTest" );
    }
}
?>
