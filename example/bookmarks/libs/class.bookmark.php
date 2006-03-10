<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Bookmark - represents a single bookmark with some meta information    **
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
require_once(dirname(__FILE__).'/../config.php');
require_once(dirname(__FILE__).'/../../../libs/genesis-core/class.item.php');

//***** Bookmark ************************************************************
/**
 * Represents a single bookmark with some meta information
 *
 * @package    example.bookmarks
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class Bookmark extends Item {
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var string
     */
    protected $uri;
    /**
     * @var string[]
     */
    protected $tags;
    /**
     * @var int
     */
    protected $user_id;
    /**
     * @var string
     */
    protected $created;

    //=========================================================================
    /**
     * @param integer $id
     * @param array<string,mixed> $data
     */
    public function __construct($id = -1, $data = null) {
        parent::__construct($id, $data);
        $this->setTableName('bookmarks');
        $this->setPrimaryKey('id');
        if ($this->id != -1) {
            $this->tags = Tags::getInstance()->getTagsForBookmark($this->id);
        }
    }

    //=========================================================================
    protected function _restoreStandardValues() {
        $this->id = -1;
        $this->title = '';
        $this->description = '';
        $this->uri = '';
        $this->tags = array();
        $this->user_id = -1;
        $this->created = null;
    }

    //=========================================================================
    /**
    * @return integer
    */
    public function getId() {
        return $this->id;
    }

    //=========================================================================
    /**
    * @param integer $value
    */
    public function setId($value) {
        $this->id = $value;
    }

    //=========================================================================
    /**
    * @return string
    */
    public function getTitle() {
        return $this->title;
    }

    //=========================================================================
    /**
    * @param string $value
    */
    public function setTitle($value) {
        $this->title = $value;
    }

    //=========================================================================
    /**
    * @return string
    */
    public function getDescription() {
        return $this->description;
    }

    //=========================================================================
    /**
    * @param string $value
    */
    public function setDescription($value) {
        $this->description = $value;
    }

    //=========================================================================
    /**
    * @return string
    */
    public function getUri() {
        return $this->uri;
    }

    //=========================================================================
    /**
    * @param string $value
    */
    public function setUri($value) {
        $this->uri = $value;
    }

    //=========================================================================
    /**
    * @return integer
    */
    public function getUserId() {
        return $this->user_id;
    }

    //=========================================================================
    /**
    * @param integer $value
    */
    public function setUserId($value) {
        $this->user_id = $value;
    }

    //=========================================================================
    /**
     * @return string
     */
    public function getCreated() {
        return $this->created;
    }

    //=========================================================================
    /**
     * @return string
     */
    public function setCreated($value) {
        $this->created = $value;
    }


    //=========================================================================
    /**
    * @return string[]
    */
    public function getTags() {
        return $this->tags;
    }

    //=========================================================================
    /**
    * @param string $value
    */
    public function addTag($value) {
        $this->tags[strtolower($value)] = $value;
    }

    //=========================================================================
    /**
    * @param string $value
    */
    public function removeTag($value) {
        unset($this->tags[strtolower($value)]);
    }

    //=========================================================================
    /**
     * Calls the Tag-Manager for insert an assoziate tags to bookmark
     */
    public function _completeFlush() {
        $tags = Tags::getInstance();
        $tags->updateBookmark($this->tags, $this->id);
    }
}

?>