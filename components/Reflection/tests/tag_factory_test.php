<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Reflection
 * @subpackage Tests
 */

class ezcReflectioniscReflectionDocTagFactoryTest extends ezcTestCase
{
    public function testCreateTag() {
        $param  = iscReflectionDocTagFactory::createTag('param', array('param', 'string', 'param'));

        self::assertType('iscReflectionDocTagParam', $param);

        $var    = iscReflectionDocTagFactory::createTag('var', array('var', 'string'));
        self::assertType('iscReflectionDocTagVar', $var);

        $return = iscReflectionDocTagFactory::createTag('return', array('return', 'string', 'hello', 'world'));
        self::assertType('iscReflectionDocTagReturn', $return);
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcReflectioniscReflectionDocTagFactoryTest" );
    }
}
?>
