<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Bookmarks - manages bookmarks table and provides all methodes         **
//**             to operate on the database table                          **
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
require_once(dirname(__FILE__).
                       '/../../../libs/genesis-core/class.dbCollection.php');
require_once(dirname(__FILE__).'/class.bookmark.php');
require_once(dirname(__FILE__).'/class.users.php');

//***** Bookmarks ***********************************************************
/**
 * Manages bookmarks table and provides all methodes to operate
 * on the database table
 * @package    example.bookmarks
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @webservice
 */
class Bookmarks extends DbCollection {

    /**
     * @var Bookmarks
     */
    private static $instance = null;

    //=======================================================================
    protected function __construct() {
        parent::__construct();
        $this->_tableName = 'bookmarks';
        $this->_primaryKey = 'id';
    }

    //=======================================================================
    /**
     * @return Bookmark
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Bookmarks();
        }
        return self::$instance;
    }

    //=======================================================================
    protected function _getItemsFromResult() {
        $this->Items = array();
        foreach ($this->_lastResult as $value) {
            if (is_array($value)) {
                $this->Items[] = new Bookmark(-1, $value);
            }
        }
    }

    //=======================================================================
    /**
     * @restmethod GET /\/(.*?)\/bookmark\/([0-9]+)/
     * @restout XbelSerializer
     * @param string $user
     * @param integer $id
     * @return Bookmark
     */
    public function getBookmark($user, $id) {
        $sql = 'SELECT b.* FROM bookmarks b JOIN users u ON (u.id=b.user_id) '.
                    'WHERE b.id = '.$this->_db->qstr($id).
                    ' AND u.username='.$this->_db->qstr($user);
        $this->_lastResult = $this->_db->Execute($sql);
        $this->_getItemsFromResult();
        return array_pop($this->Items);
    }

    //=======================================================================
    /**
     * @restmethod GET /\/(.*?)\/bookmarks\/(.*?)\//
     * @restout XbelSerializer
     * @param string $user
     * @param string $tag
     * @return Bookmark[]
     */
    public function getNewestBookmarksWithTag($user, $tag) {
        $sql = 'SELECT b.* FROM bookmarks b '.
                   'JOIN users u ON (u.id=b.user_id) '.
                   'JOIN tags_has_bookmarks tb ON (tb.bookmarks_id=b.id) '.
                   'JOIN tags t ON (t.id=tb.tags_id) '.
                   'WHERE u.username='.$this->_db->qstr($user).
                   ' AND LOWER(t.title) = LOWER('.$this->_db->qstr($tag).') '.
                   'LIMIT 20';
        $this->_lastResult = $this->_db->Execute($sql);
        $this->_getItemsFromResult();
        return $this->Items;
    }

    //=======================================================================
    /**
     * @restmethod GET /\/(.*?)\/bookmarks\/date\/([0-9]{4})\//
     * @param string $user
     * @param integer $year
     * @return Bookmark[]
     */
    public function getBookmarksInYear($user, $year) {
        $sql = 'SELECT b.* FROM bookmarks b '.
                    'JOIN users u ON (u.id=b.user_id) '.
                    'WHERE u.username='.$this->_db->qstr($user).
                    ' AND YEAR(b.created) ='.$this->_db->qstr($year);

        $this->_lastResult = $this->_db->Execute($sql);
        $this->_getItemsFromResult();
        return $this->Items;
    }

    //=======================================================================
    /**
     * @restmethod GET /\/(.*?)\/bookmarks\/date\/([0-9]{4})\/([0-9]{1,2})\//
     * @param string $user
     * @param integer $year
     * @param integer $month
     * @return Bookmark[]
     */
    public function getBookmarksInYearAndMount($user, $year, $month) {
        $sql = 'SELECT b.* FROM bookmarks b '.
                    'JOIN users u ON (u.id=b.user_id) '.
                    'WHERE u.username='.$this->_db->qstr($user).
                    ' AND YEAR(b.created) ='.$this->_db->qstr($year).
                    ' AND MONTH(b.created) ='.$this->_db->qstr($month);
        $this->_lastResult = $this->_db->Execute($sql);
        $this->_getItemsFromResult();
        return $this->Items;
    }

    //=======================================================================
    /**
     * @restmethod POST /\/(.*?)\/bookmarks\//
     * @restin XbelSerializer
     * @param string $user
     * @param Bookmark $bookmark
     */
    public function addBookmark($user, Bookmark $bookmark) {
        $bookmark->setId(-1);
        $bookmark->setCreated(mktime());
        $id = Users::getInstance()->getUserId($user);
        $bookmark->setUserId($id);
        $bookmark->flush();
    }

    //=======================================================================
    /**
     * @restmethod PUT /\/(.*?)\/bookmark\/([0-9]+)/
     * @restin XbelSerializer
     * @param string $user
     * @param integer $id
     * @param Bookmark $bookmark
     */
    public function updateBookmark($user, $id, Bookmark $bookmark) {
        $bookmark->setId($id);
        $userid = Users::getInstance()->getUserId($user);
        $bookmark->setUserId($userid);
        $bookmark->flush();
    }

    //=======================================================================
    /**
     * @restmethod GET /\/(.*?)\/bookmarks\//
     * @param string $user
     * @return Bookmark[]
     */
    public function getNewestBookmarks($user) {

        $sql = 'SELECT b.* FROM bookmarks b ';
        if ($user != 'all') {
            $sql .= 'JOIN users u ON (u.id=b.user_id) '.
                    'WHERE u.username='.$this->_db->qstr($user);
        }
        $sql .= ' LIMIT 20';
        $this->_lastResult = $this->_db->Execute($sql);
        $this->_getItemsFromResult();
        return $this->Items;
    }

}

?>