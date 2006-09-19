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
        self::assertTrue($method instanceof ExtReflectionMethod);
        self::assertEquals($method->getName(), 'getMethod');
    }


    public function testGetConstructor() {
        throw new Exception('not implemented');
    }


    public function testGetMethods() {
        throw new Exception('not implemented');
    }

    public function testGetParentClass() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        $parent = $class->getParentClass();

        self::assertTrue($parent instanceof ReflectionClass);
        self::assertEquals($parent->getName(), 'ReflectionClass');

        $parentParent = $parent->getParentClass();
        self::assertNull($parentParent);
    }

    public function testGetProperty() {
        throw new Exception('not implemented');
    }

    public function testGetProperties() {
        throw new Exception('not implemented');
    }

    public function testIsWebService() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        self::assertFalse($class->isWebService());

        $class = new ExtReflectionClass('TestWebservice');
        self::assertTrue($class->isWebService());
    }

    public function testGetShortDescription() {
        throw new Exception('not implemented');
    }

    public function testGetLongDescription() {
        throw new Exception('not implemented');
    }

    public function testIsTagged() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        self::assertFalse($class->isTagged('foobar'));

        $class = new ExtReflectionClass('TestWebservice');
        self::assertTrue($class->isTagged('foobar'));
    }

    private function deleteFromArray($needle, &$array) {
        foreach ($array as $key => $value) {
            if ($value == $needle) {
                unset($array[$key]);
                return;
            }
        }
    }

    public function testGetTags() {
        $class = new ExtReflectionClass('ExtReflectionClass');
        $tags = $class->getTags();

        $expectedTags = array('package', 'author', 'author', 'copyright',
                              'license');
        foreach ($tags as $tag) {
            self::assertType('PHPDocTag', $tag);
            self::assertContains($tag->getName(), $expectedTags);

            $this->deleteFromArray($tag->getName(), $expectedTags);
        }
        self::assertTrue(count($expectedTags) == 0);

        $expectedTags = array('webservice', 'foobar');
        $class = new ExtReflectionClass('TestWebservice');
        $tags = $class->getTags();
        foreach ($tags as $tag) {
            self::assertType('PHPDocTag', $tag);
            self::assertContains($tag->getName(), $expectedTags);

            $this->deleteFromArray($tag->getName(), $expectedTags);
        }
        self::assertTrue(count($expectedTags) == 0);
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
