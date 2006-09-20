<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ExtendedReflection
 * @subpackage Tests
 */

class ezcExtendedReflectionClassTest extends ezcTestCase
{

    public function testGetMethod() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        $method = $class->getMethod('getMethod');
        self::assertType('ExtReflectionMethod', $method);
        self::assertEquals($method->getName(), 'getMethod');
    }


    public function testGetConstructor() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        $method = $class->getConstructor();
        self::assertType('ExtReflectionMethod', $method);
        self::assertEquals($method->getName(), '__construct');
    }


    public function testGetMethods() {
        $class = new ExtReflectionClass('TestWebservice');
        $methods = $class->getMethods();
        self::assertEquals(0, count($methods));

        $class = new ExtReflectionClass('TestMethods');
        $methods = $class->getMethods();

        $expectedMethods = array('__construct', 'm1', 'm2', 'm3', 'm4');
        foreach ($methods as $method) {
            self::assertType('ExtReflectionMethod', $method);
            self::assertContains($method->getName(), $expectedMethods);

            ExtendedReflectionTestHelper::deleteFromArray($method->getName(), $expectedMethods);
        }
        self::assertEquals(0, count($expectedMethods));
    }

    public function testGetParentClass() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        $parent = $class->getParentClass();

        self::assertType('ReflectionClass', $parent);
        self::assertEquals($parent->getName(), 'ReflectionClass');

        $parentParent = $parent->getParentClass();
        self::assertNull($parentParent);
    }

    public function testGetProperty() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        $prop = $class->getProperty('docParser');

        self::assertType('ExtReflectionProperty', $prop);
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
        $class = new ExtReflectionClass('TestWebservice');
        $properties = $class->getProperties();

        $expected = array('prop1', 'prop2', 'prop3');

        foreach ($properties as $prop) {
            self::assertType('ExtReflectionProperty', $prop);
            self::assertContains($prop->getName(), $expected);

            ExtendedReflectionTestHelper::deleteFromArray($prop->getName(), $expected);
        }
        self::assertEquals(0, count($expected));
    }

    public function testIsWebService() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        self::assertFalse($class->isWebService());

        $class = new ExtReflectionClass('TestWebservice');
        self::assertTrue($class->isWebService());
    }

    public function testGetShortDescription() {
        $class = new ExtReflectionClass('TestWebservice');
        $desc = $class->getShortDescription();

        self::assertEquals('This is the short description', $desc);
    }

    public function testGetLongDescription() {
        $class = new ExtReflectionClass('TestWebservice');
        $desc = $class->getLongDescription();

        $expected = "This is the long description with may be additional infos and much more lines\nof text.\n\nEmpty lines are valide to.\n\nfoo bar";
        self::assertEquals($expected, $desc);
    }

    public function testIsTagged() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        self::assertFalse($class->isTagged('foobar'));

        $class = new ExtReflectionClass('TestWebservice');
        self::assertTrue($class->isTagged('foobar'));
    }



    public function testGetTags() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        $tags = $class->getTags();

        $expectedTags = array('package', 'author', 'author', 'copyright',
                              'license');
        ExtendedReflectionTestHelper::expectedTags($expectedTags, $tags, $this);

        $expectedTags = array('webservice', 'foobar');
        $class = new ExtReflectionClass('TestWebservice');
        $tags = $class->getTags();
        ExtendedReflectionTestHelper::expectedTags($expectedTags, $tags, $this);
    }

    public function testGetExtension() {
        $class = new ExtReflectionClass('ReflectionClass');
        $ext = $class->getExtension();
        self::assertType('ExtReflectionExtension', $ext);
        self::assertEquals($ext->getName(), 'Reflection');

        $class = new ExtReflectionClass('TestWebservice');
        $ext = $class->getExtension();
        self::assertNull($ext);
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcExtendedReflectionClassTest" );
    }
}
?>
