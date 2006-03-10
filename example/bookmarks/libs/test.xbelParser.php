<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** TEST Unit for XbelSerializer                                          **
//**                                                                       **
//** Project:    Advanced Database Technology Seminar                      **
//**             Hasso-Plattner-Institute for Software Systems Engineering **
//**             RESTful Web Services                                      **
//**                                                                       **
//** @package    example.bookmarks                                         **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once('PHPUnit2/Framework/TestCase.php');
require_once('class.xbelParser.php');

//***** XbelParserTest ******************************************************
/**
 * Test Class for XbelParser
 *
 * @package    example.bookmarks
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class XbelParserTest extends PHPUnit2_Framework_TestCase {

    //=======================================================================
    /**
     * Test parser with a single bookmark
     */
    public function testSingleBookmark() {
        $xbel = <<<EOF
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE xbel PUBLIC
       "+//IDN python.org//DTD XML Bookmark Exchange
        Language 1.0//EN//XML"
       "http://www.python.org/topics/xml/dtds/xbel-1.0.dtd">
<xbel version="1.0">
	<bookmark
		href="http://www.xml.com/pub/a/2005/02/09/xml-http-request.html">
		<title>Very Dynamic Web Interfaces</title>
		<info>
			<metadata
				owner="http://example.com/documentation/xbel/edit">
				http://example.com/jcgregorio/bookmark/1
			</metadata>
			<metadata
				owner="http://example.com/documentation/xbel/tags">
				<tag>XML</tag>
				<tag>XForms</tag>
			</metadata>
		</info>
		<desc>
			Using XMLHttpRequest to build dynamic web interfaces.
		</desc>
	</bookmark>
</xbel>
EOF;
        $parser = new XbelParser();
        $parser->parse($xbel);
        $bookmarks = $parser->getBookmarks();
        $this->assertType('array', $bookmarks, '$parser->getBookmarks() return type should be an array');
        $this->assertTrue(isset($bookmarks[0]), 'a bookmark had should been found');

        $bookmark = $bookmarks[0];
        $this->assertEquals('http://www.xml.com/pub/a/2005/02/09/xml-http-request.html', $bookmark->getUri(), 'Wrong uri had been parsed');
        $this->assertEquals('Using XMLHttpRequest to build dynamic web interfaces.', $bookmark->getDescription(), 'Wrong description parsed');
        $this->assertEquals('Very Dynamic Web Interfaces', $bookmark->getTitle(), 'wrong title parsed');
        $tags = $bookmark->getTags();
        $this->assertContains('XML', $tags, 'tag not found');
        $this->assertContains('XForms', $tags, 'tag not found');
    }
}

?>