<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ExtendedReflection
 * @subpackage Tests
 */

class ezcExtendedReflectionPhpDocTagFactoryTest extends ezcTestCase
{
    public function testCreateTag() {
        $param  = PHPDocTagFactory::createTag('param', array('param', 'string', 'param'));

        self::assertType('PHPDocParamTag', $param);

        $var    = PHPDocTagFactory::createTag('var', array('var', 'string'));
        self::assertType('PHPDocVarTag', $var);

        $return = PHPDocTagFactory::createTag('return', array('return', 'string', 'hello', 'world'));
        self::assertType('PHPDocReturnTag', $return);
    }

    public static function suite()
    {
         return new ezcTestSuite( "ezcExtendedReflectionPhpDocTagFactoryTest" );
    }
}
?>
