<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Tags      - represents the collection of all used tags                **
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
require_once(dirname(__FILE__).'/../../../libs/genesis-core/class.dbCollection.php');
define('GLOBAL_DEBUG', true);

//***** Tags ****************************************************************
/**
 * Represents the collection of all used tags
 *
 * @package    example.bookmarks
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @webservice
 */
class Tags extends DbCollection {

    /**
     * @var Tags
     */
    private static $instance = null;

    //=========================================================================
    /**
     * @return Tags
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Tags();
        }
        return self::$instance;
    }

    //=========================================================================
    /**
     * Update assoziation between a bookmark and its tags
     * @param string[] $tags
     * @param integer $bookmark_id
     */
    public function updateBookmark($tags, $bookmark_id) {
        $ids = $this->getIds($tags);

        $sql = 'DELETE FROM tags_has_bookmarks WHERE bookmarks_id='.
                                                            $bookmark_id;
        $this->_db->Execute($sql);
        $sql = 'INSERT INTO tags_has_bookmarks VALUES ';
        $values = '';
        foreach ($ids as $id) {
            if (strlen($values)>0) $values.=',';
            $values .= '('.$id.', '.$bookmark_id.')';
        }
        $sql .= $values;
        $this->_db->Execute($sql);
    }

    //=========================================================================
    /**
     * Get the ids from given tags, inserts tags before if necessary
     * @param string[] $tags
     * @return integer[]
     */
    public function getIds($tags) {
        if (!is_array($tags) or count($tags) < 1) {
            return array();
        }

        foreach ($tags as $tag) {
            $sql = 'INSERT INTO tags VALUES (default,'
                                                .$this->_db->qstr($tag).')';
            $this->_db->Execute($sql);
        }

        $sql = 'SELECT id FROM tags WHERE ';
        $where = '';
        foreach ($tags as $tag) {
            if (strlen($where)>0) $where.=' OR ';
            $where .= 'LOWER(title) = lower(\''.$tag.'\')';
        }
        $sql .= $where;
        $result = $this->_db->Execute($sql);

        $r = array();
        foreach ($result as $key => $value) {
            $r[] = (int)$value['id'];
        }
        return $r;
    }

    //=========================================================================
    /**
     * @param integer $id
     * @return string[]
     */
    public function getTagsForBookmark($id) {
        $sql = 'SELECT t.title FROM tags t JOIN tags_has_bookmarks tb '.
                'ON (tb.tags_id=t.id) WHERE tb.bookmarks_id = '.
                $this->_db->qstr($id);

        $res = $this->_db->Execute($sql);
        $r = array();
        foreach ($res as $tag) {
            $r[] = $tag['title'];
        }
        return $r;
    }

    //=========================================================================
    /**
     * @restmethod GET /\/(.*?)\/keywords\//
     * @restout TagsSerializer
     * @param integer $id
     * @return string[]
     */
    public function getTagsByUser($user) {
        $sql = 'SELECT t.title FROM tags t ';
        if ($user != 'all') {
            $sql .= 'JOIN tags_has_bookmarks tb ON (tb.tags_id=t.id) '.
                    'JOIN bookmarks b ON (tb.bookmarks_id=b.id) '.
                    'JOIN users u ON (b.user_id=u.id) '.
                    'WHERE u.username = '.$this->_db->qstr($user);
        }

        $res = $this->_db->Execute($sql);
        $r = array();
        foreach ($res as $tag) {
            $r[] = $tag['title'];
        }
        return $r;
    }

    //=========================================================================
    protected function _getItemsFromResult() {
        $this->Items = array();

        foreach ($this->_lastResult as $value) {
            $this->Items[] = (int)$value['id'];
        }
    }

    //=========================================================================
    /**
     * @return string[]
     */
    public function getItems() {
        return parent::getItems();
    }
}
?>