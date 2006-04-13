<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** DbCollection - Acts as root class for database table manager          **
//**                                                                       **
//** Project: TOOLSLAVE Genesis Framework                                  **
//**                                                                       **
//** @package    genesis-core                                              **
//** @author     Stefan Marr <marr@toolslave.com>                          **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
include_once(dirname(__FILE__).'/class.singleton.php');
include_once(dirname(__FILE__).'/class.dbManager.php');

//***** DbCollection ********************************************************
/**
 * Acts as root class for database table manager classes
 *
 * Manages Item objects representing table rows (entities)
 *
 * @package    libs.genesis-core
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
abstract class DbCollection implements Singleton {

  /**
   * @var string
   */
  protected $_tableName;

  /**
   * @var string
   */
  protected $_primaryKey;

  /**
   * Array mit wsDBItems
   * Enthält all die Items, welche bereits aus der Datenbank geladen wurden
   */
  public $Items;

  /**
   * Referenz auf eine ADOdb Datenbankverbindung
   * @var ADOConnection
   */
  protected $_db;

  /**
   * @var ADOResultSet
   */
  protected $_lastResult;

  //=========================================================================
  protected function __construct() {
    $this->_db = DbManager::getConnection();
  }

  //=========================================================================
  /**
   * @param string $condition
   * @param integer $start
   * @param integer $count
   * @param string $sort (SQL string)
   * @access public
   * @return Item[]
   * @desc Gibt die angeforderten Objekte aus der Datenbank zurück
   */
  public function getItems($condition = '', $start = -1, $count = -1,
                           $properties = '*', $sort = '') {
    $sql = 'SELECT '.$properties.' FROM '.$this->_tableName;
    if ($condition != '') {
      $sql .= ' WHERE '.$condition;
    }

    if ($sort != '') {
      $sql .= ' ORDER BY '.$sort;
    }

    if (($start != -1) or ($count != -1)) {
      $this->_lastResult = $this->_db->SelectLimit($sql, $count, $start);
    }
    else {
      $this->_lastResult = $this->_db->Execute($sql);
    }
    $this->_getItemsFromResult();
    return $this->Items;
  }

  //=========================================================================
  /**
   * Muss überschrieben werden und implementiert in der abgeleiteten Klasse
   * die Umwandlung vom Result ins Objekt
   */
  abstract protected function _getItemsFromResult();

  //=========================================================================
  /**
   * Speichert alle Änderungen an Items in der Liste in die Datenbank
   *
   * Es wird nur $this->Items geprüft
   *
   * @access public
   */
  function flushItems(){
    foreach ($this->Items as $value) {
      $value->flush();
    }
  }

  //=========================================================================
	/**
	 * Löscht das angegebene Item aus der Datenbank
	 * kann überschrieben werden um Verknüpfte Daten gleich mit aus
	 * der Datenbank zu entfernen
       * 
       * @param int $id
	 * @access public
	 * @virtual
	 */
	public function deleteItem($id) {
		$this->_deleteItem($id);
	}

  //=========================================================================
  /**
   * Löscht das angegebene Item aus der Datenbank
   * Darf nicht überschrieben werden
   * @param int $id
   */
	final protected function _deleteItem($id) {
		$this->_db->Execute('DELETE FROM '.$this->_tableName.' WHERE '.
		      $this->_primaryKey.'='.$id);
	}
}
?>