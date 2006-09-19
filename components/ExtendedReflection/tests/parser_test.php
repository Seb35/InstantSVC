<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package ExtendedReflection
 * @subpackage Tests
 */

class ezcExtendedReflectionPhpDocParserTest extends ezcTestCase
{
    /**
     * @var string[]
     */
    private static $docs;

    public function testGetTagsByName() {
        $parser = new PHPDocParser(self::$docs[0]);
        $parser->parse();
        $tags = $parser->getTagsByName('copyright');
        self::assertEquals(1, count($tags));

        $tags = $parser->getTagsByName('filesource');
        self::assertEquals(1, count($tags));

        $tags = $parser->getTagsByName('noneExistingTag');
        self::assertEquals(0, count($tags));

        $parser = new PHPDocParser(self::$docs[2]);
        $parser->parse();
        $tags = $parser->getTagsByName('onetagonly');
        self::assertEquals(1, count($tags));

        $parser = new PHPDocParser(self::$docs[3]);
        $parser->parse();
        $tags = $parser->getTagsByName('param');
        self::assertEquals(1, count($tags));

        $parser = new PHPDocParser(self::$docs[4]);
        $parser->parse();
        $tags = $parser->getTagsByName('foobar');
        self::assertEquals(1, count($tags));

        $parser = new PHPDocParser(self::$docs[6]);
        $parser->parse();
        $tags = $parser->getTagsByName('author');
        self::assertEquals(1, count($tags));
    }

    public function testGetTags() {
        $parser = new PHPDocParser(self::$docs[0]);
        $parser->parse();
        $tags = $parser->getTags();
        self::assertEquals(6, count($tags));

        $parser = new PHPDocParser(self::$docs[1]);
        $parser->parse();
        $tags = $parser->getTags();
        self::assertEquals(0, count($tags));

        $parser = new PHPDocParser(self::$docs[2]);
        $parser->parse();
        $tags = $parser->getTags();
        self::assertEquals(1, count($tags));

        $parser = new PHPDocParser(self::$docs[3]);
        $parser->parse();
        $tags = $parser->getTags();
        self::assertEquals(2, count($tags));

        $parser = new PHPDocParser(self::$docs[4]);
        $parser->parse();
        $tags = $parser->getTags();
        self::assertEquals(3, count($tags));

        $parser = new PHPDocParser(self::$docs[5]);
        $parser->parse();
        $tags = $parser->getTags();
        self::assertEquals(0, count($tags));

        $parser = new PHPDocParser(self::$docs[6]);
        $parser->parse();
        $tags = $parser->getTags();
        self::assertEquals(6, count($tags));
    }

    public function testGetParamTags() {
        $parser = new PHPDocParser(self::$docs[0]);
        $parser->parse();
        $tags = $parser->getParamTags();
        self::assertEquals(0, count($tags));

        $parser = new PHPDocParser(self::$docs[3]);
        $parser->parse();
        $tags = $parser->getParamTags();
        self::assertEquals(1, count($tags));

        $parser = new PHPDocParser(self::$docs[6]);
        $parser->parse();
        $tags = $parser->getParamTags();
        self::assertEquals(3, count($tags));
        self::assertEquals('test', $tags[0]->getParamName());
        self::assertEquals('string', $tags[0]->getType());

        self::assertEquals('test3', $tags[2]->getParamName());
        self::assertEquals('NoneExistingType', $tags[2]->getType());
    }

    public function testGetVarTags() {
        $comment = <<<EOF
/**
* @var string
*/
EOF;
        $parser = new PHPDocParser($comment);
        $parser->parse();
        $tags = $parser->getVarTags();
        self::assertEquals('string', $tags[0]->getType());
    }

    public function testGetReturnTags() {
        $parser = new PHPDocParser(self::$docs[6]);
        $parser->parse();
        $tags = $parser->getReturnTags();

        self::assertEquals('Hello World', $tags[0]->getDescription());
        self::assertEquals('string', $tags[0]->getType());
    }

    public function testIsTagged() {
        $parser = new PHPDocParser(self::$docs[6]);
        $parser->parse();
        self::assertTrue($parser->isTagged('return'));
    }

    public function testGetShortDescription() {
        $class = new ReflectionClass('TestWebservice');
        $doc = $class->getDocComment();
        $parser = new PHPDocParser($doc);
        $parser->parse();
        $desc = $parser->getShortDescription();

        self::assertEquals('This is the short description', $desc);
    }

    public function testGetLongDescription() {
        $class = new ReflectionClass('TestWebservice');
        $doc = $class->getDocComment();
        $parser = new PHPDocParser($doc);
        $parser->parse();
        $desc = $parser->getLongDescription();

        $expected = "This is the long description with may be additional infos and much more lines\nof text.\n\nEmpty lines are valide to.\n\nfoo bar";
        self::assertEquals($expected, $desc);
    }

    public static function suite()
    {
        self::$docs = array();
        $class = new ReflectionClass('ezcExtendedReflectionPhpDocParserTest');
        self::$docs[] = $class->getDocComment();

        $class = new ReflectionClass('TestMethods');
        self::$docs[] = $class->getDocComment();
        $methods = $class->getMethods();

        foreach ($methods as $method) {
            self::$docs[] = $method->getDocComment();
        }

        return new ezcTestSuite( "ezcExtendedReflectionPhpDocParserTest" );
    }
}
?>
