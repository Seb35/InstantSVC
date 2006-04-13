<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** XbelSerializer - combines Serializer and Parser to be used            **
//**                  by the RESTServer                                    **
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
require_once('class.xbelParser.php');
require_once('class.user.php');
require_once(dirname(__FILE__).'/../../../libs/misc/interface.serializer.php');

//***** XbelSerializer ******************************************************
/**
 * XbelSerializer combines data serialization and deserialization
 * to be used by the RESTServer
 *
 * @package    example.bookmarks
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class XbelSerializer implements Serializer {

  //=======================================================================
  /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data) {
        $res = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $res.= '<!DOCTYPE xbel PUBLIC "+//IDN python.org//DTD XML Bookmark Exchange Language 1.0//EN//XML" "http://www.python.org/topics/xml/dtds/xbel-1.0.dtd">'."\n";
        $res.= '<xbel version="1.0">'."\n";

        if (!is_array($data)) {
            $data = array($data);
        }

        foreach ($data as $bookmark) {
            if ($bookmark instanceof Bookmark) {
                $res.= '<bookmark href="'.$bookmark->getUri().'">'."\n";
                $res.= '<title>'.$bookmark->getTitle().$bookmark->getUserId().'</title>'."\n";
                $user = new User($bookmark->getUserId());
		        $res.= '<info><metadata	owner="http://example.com/documentation/xbel/edit">'."\n";
                $res.= REST_BASE.'/'.$user->getName().'/bookmark/'.$bookmark->getId()."\n";
                $res.= "</metadata>\n";
                $res.= '<metadata owner="http://example.com/documentation/xbel/tags">';
                $tags = $bookmark->getTags();
                foreach ($tags as $tag) {
				    $res.= '<tag>'.$tag.'</tag>';
                }
                $res.= "\n</metadata>\n";
		        $res.= "</info>\n";
		        $res.= "<desc>\n";
		        $res.= $bookmark->getDescription();
		        $res.= "</desc>\n";
		        $res.= "</bookmark>\n";
            }
        } //end foreach
        $res.= '</xbel>';
        return $res;
    } //end serialize

    //=======================================================================
    /**
     * @param string $str
     * @return mixed
     */
    public function deserialize($str) {
        $parser = new XbelParser();
        $parser->parse($str);
        $bookmarks = $parser->getBookmarks();
        if (count($bookmarks) < 2) {
            if (isset($bookmarks[0])) {
                return $bookmarks[0];
            }
        }
        return $bookmarks;
    }
}
?>