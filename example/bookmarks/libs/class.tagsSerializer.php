<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** TagsSerializer - creates simple <tag/> sequenzes                      **
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
require_once(dirname(__FILE__).'/../../../libs/misc/interface.serializer.php');

//***** TagsSerializer ******************************************************
/**
 * Creates simple <tag/> sequenzes
 *
 * @package    example.bookmarks
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class TagsSerializer implements Serializer {

    //=======================================================================
    /**
     * Create sequence of <tag/>'s from input strings
     * @param mixed $data
     * @return string
     */
    public function serialize($data) {
        header('Content-type: text/xml');

        $res = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $res.= '<tags>'."\n";

        if (!is_array($data)) {
            $data = array($data);
        }

        foreach ($data as $tag) {
            if (is_string($tag)) {
               $res.= "<tag>$tag</tag>\n";
            }
        }
        $res.= '</tags>';
        return $res;
    }

    //=======================================================================
    /**
     * Doesn't do anything
     * @param string $str
     * @return mixed
     */
    public function deserialize($str) {
        return null;
    }
}
?>