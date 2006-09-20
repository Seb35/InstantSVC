<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectionTest extends ezcTestCase
{
    public function testGetTypeByName() {
        $api = iscReflectionApi::getInstance();
        $string = $api->getTypeByName('string');
        self::assertEquals('string', $string->toString());

        $int = $api->getTypeByName('int');
        self::assertEquals('integer', $int->toString());

        $webservice = $api->getTypeByName('TestWebservice');
        self::assertEquals('TestWebservice', $webservice->toString());

        $class = $api->getTypeByName('iscReflectionClass');
        self::assertEquals('iscReflectionClass', $class->toString());

    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcReflectionTest" );
    }
}
?>
