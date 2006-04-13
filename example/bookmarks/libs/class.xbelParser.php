<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** XbelParser                                                            **
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
require_once('class.bookmark.php');

//***** XbelParser **********************************************************
/**
 * Simple parser for the XBEL Bookmark format
 *
 * isn't complete in sense of the standard
 *
 * @package    example.bookmarks
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class XbelParser {

    /**
     * @var string
     */
    public $REST_EDIT_URL = 'http://example.com/documentation/xbel/edit';

    /**
     * @var string
     */
    public $XBEL_TAGS = 'http://example.com/documentation/xbel/tags';

    /**
     * @var resource
     */
    private $parser;

    /**
     * @var Bookmark[]
     */
    private $bookmarks;

    /**
     * @var Bookmark
     */
    private $currentBookmark = null;

    /**
     * @var string[]
     */
    private $tagStack = array();

    //=======================================================================
    /**
     * @param resource $parser
     * @param string $tag
     * @param array<string,string> $attrs
     */
    public function startElement($parser, $tag, $attrs){
        array_unshift($this->tagStack, $tag);

        switch($tag) {
            case 'bookmark':
                $this->currentBookmark = new Bookmark();
                $this->bookmarks[] = $this->currentBookmark;
                $this->currentBookmark->setUri($attrs['href']);
                break;
            case 'metadata':
                array_unshift($this->tagStack, $attrs['owner']);
            case 'tags':
            case 'tag':
            case 'xbel':
            case 'title':
            case 'desc':
            case 'info':
                break;
        } //end switch
    } //end startElement

    //=======================================================================
    /**
     * @param resource $parser
     * @param string $data
     */
    public function characterData($parser, $data) {
        if (isset($this->tagStack[0])) {
            switch ($this->tagStack[0]) {
                case 'title':
                    if ($this->currentBookmark != null) {
                        $this->currentBookmark->setTitle(trim($data));
                    }
                    break;
                case 'desc':
                    if ($this->currentBookmark != null) {
                        $this->currentBookmark->setDescription(trim($data));
                    }
                    break;
                case 'tag':
                    if ($this->currentBookmark != null) {
                        $this->currentBookmark->addTag(trim($data));
                    }
                    break;
                case $this->REST_EDIT_URL:
                case 'metadata':
                case 'xbel':
                case 'info':
                case 'bookmark':
                    break;
            }
        }
    } //end characterData

    //=======================================================================
    /**
     * @param resource $parser
     * @param string $tag
     */
    public function endElement($parser, $tag) {
        switch($tag){
            case 'metadata':
                //pop the owner tag attrib
                array_shift($this->tagStack);
                break;
            case 'bookmark':
            case 'tag':
            case 'xbel':
            case 'title':
            case 'desc':
            case 'info':
                break;
        }
        array_shift($this->tagStack);
    }

    //=======================================================================
    public function __construct() {
        $this->parser = xml_parser_create();
        xml_set_object($this->parser, $this);
        xml_set_element_handler($this->parser, 'startElement', 'endElement');
        xml_set_character_data_handler($this->parser, 'characterData');

        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
        xml_parser_set_option($this->parser, XML_OPTION_TARGET_ENCODING, 'UTF-8');
    }

    //=======================================================================
    /**
     * @param string $str
     */
    public function parse($str) {
        xml_parse($this->parser, $str);
        xml_parser_free($this->parser);
    }

    //=======================================================================
    /**
     * @return Bookmark[]
     */
    public function getBookmarks() {
        return $this->bookmarks;
    }
}

?>