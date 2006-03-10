<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** User      - is the user database object                               **
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
require_once(dirname(__FILE__).'/../../../libs/genesis-core/class.item.php');

/**
 * Is the user database object
 *
 * @package    example.bookmarks
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class User extends Item {
    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $username;
    /**
     * @var string
     */
    protected $pwd_md5;
    /**
     * @var string
     */
    protected $pwd_rfc2617;

    //=========================================================================
    /**
     * @param integer $id
     * @param array<string,mixed> $data
     */
    public function __construct($id = -1, $data = null) {
        $this->setTableName('users');
        $this->setPrimaryKey('id');
        parent::__construct($id, $data);
    }

    //=========================================================================
    protected function _restoreStandardValues() {
        $this->id = -1;
        $this->username = '';
        $this->pwd_md5 = '';
        $this->pwd_rfc2617 = '';
    }

    //=========================================================================
    /**
    * @return int
    */
    public function getId() {
        return intval($this->id);
    }

    //=========================================================================
    /**
    * @param int $value
    */
    public function setId($value) {
        $this->id = $value;
    }

    //=========================================================================
    /**
    * @return string
    */
    public function getName() {
        return $this->username;
    }

    //=========================================================================
    /**
    * @param string $value
    */
    public function setName($value) {
        $this->username = $value;
    }

    //=========================================================================
    /**
    * @return string
    */
    public function getPasswordMd5() {
        return $this->pwd_md5;
    }

    //=========================================================================
    /**
    * @param string $value
    */
    public function setPasswordMd5($value) {
        $this->pwd_md5 = $value;
    }

    //=========================================================================
    /**
    * @return string
    */
    public function getPasswordRfc2617() {
        return $this->pwd_rfc2617;
    }

    //=========================================================================
    /**
    * @param string $value
    */
    public function setPasswordRfc2617($value) {
        $this->pwd_rfc2617 = $value;
    }

}

?>