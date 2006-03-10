<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Users     - is the users database table manager                       **
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

//***** Users ***************************************************************
/**
 * Is the users database table manager
 *
 * @package    example.bookmarks
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @webservice
 */
class Users extends DbCollection {

    /**
     * @var Users
     */
    private static $instance = null;

    //=======================================================================
    protected function __construct() {
        parent::__construct();
    }

    //=======================================================================
    protected function _getItemsFromResult() {}

    //=======================================================================
    /**
     * @return Users
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Users();
        }
        return self::$instance;
    }

    //=======================================================================
    /**
     * @param string $user username
     * @return integer
     */
    public function getUserId($user) {
        $sql = 'SELECT id FROM users WHERE username='.$this->_db->qstr($user);
        $r = $this->_db->Execute($sql);
        foreach ($r as $user) {
            return $user['id'];
        }
    }

    //=======================================================================
    /**
     * @restmethod GET /([^\/]+)/
     * @param string $name username
     * @return User
     */
    public function getUser($name) {
        $sql = 'SELECT * FROM users WHERE username='.$this->_db->qstr($name);
        return $user;
    }
}
?>