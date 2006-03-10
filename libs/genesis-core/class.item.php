<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Item - Base Class for all domain specific items                       **
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
include_once(dirname(__FILE__).'/class.dbManager.php');

//***** Item ****************************************************************
/**
 * Abstract base class for all domain specific items
 *
 * @package    libs.genesis-core
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
abstract class Item {

  /**
   * @var ADOConnection
   */
  private $_db;

  /**
   * @var string
   */
  private $_tableName;

  /**
   * @var string
   */
  private $_primaryKey;

  /**
  * Speichert das Ergebnis der Datenbank-Abfrage für spätere
  * Update-Operationen
  * @var ADOResultSet
  */
  private $__adodbResult;

  //=========================================================================
  /**
  * initializes object with data from given array
  *
  * @param array $data
  */
  public function __construct($id = -1, $data = null){
    $this->_restoreStandardValues();
    $this->_db = DbManager::getConnection();

    if ($data != null) {
        foreach ($data as $key => $value) {
        	if (isset($this->$key)) {
            	$this->$key = $value;
         	}
	  }
    }
    else {
      if (($id != -1) and ($id != 'new')) {
        if(!$this->_loadFromDB($id)) {
          throw new Exception('Requested Object not in DB.');
        }
      }
    }
  }

  //=========================================================================
  /**
  * Holt die Daten aus der Datenbank und legt sie in den dafür vorgesehenen
  * Variablen ab
  */
  private function __loadFromDB($id, $table) {
    $this->__adodbResult = $this->_db->Execute('SELECT * FROM '.$table.
            ' WHERE '.$this->_primaryKey.'='.$this->_db->qstr($id));
    if (is_array($this->__adodbResult->fields)) {
      foreach ($this->__adodbResult->fields as $key => $value) {
     		$this->$key = $value;
      }
      return true;
    }
    else {
      return false;
    }
  }

  //=========================================================================
  /**
  * lädt die Daten aus der Datenbank
  * @param integer $id
  */
  protected function _loadFromDB($id){
    return $this->__loadFromDB($id, $this->_tableName);
  }

  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */
  abstract protected function _restoreStandardValues();

  //=========================================================================
  protected function _flushInsert($update) {
    unset($update[$this->_primaryKey]);
    $sql = $this->_db->GetInsertSQL($this->__adodbResult, $update);
    $this->_db->Execute($sql);
    $this->{$this->_primaryKey} = $this->_db->Insert_ID();
  }

  //=========================================================================
  protected function _flushUpdate($update) {
    $sql = $this->_db->GetUpdateSQL($this->__adodbResult, $update);
    $this->_db->Execute($sql);
  }

  //=========================================================================
  /**
   * Override this method to do anything necessary before updateting database
   */
  protected function _prepareFlush() {

  }

  //=========================================================================
  /**
   * Override this method to do anything necessary after updateting database
   */
  protected function _completeFlush() {

  }

  //=========================================================================
  /**
   * Schreibt alle Änderungen in die Datenbank
   */
  final public function flush() {
    $this->_prepareFlush();
    $update = array();
    foreach ($this as $key => $value) {
        $update[$key] = $value;
    }

    if (count($update) > 0) {
      if ($this->__adodbResult == null) {
        $this->_getTableLayout();
      }

      if (!isset($this->{$this->_primaryKey}) or
        (intval($this->{$this->_primaryKey}) == -1) or
        ($this->{$this->_primaryKey} == null))
      {
        $this->_flushInsert($update);
      }
      else {
        $this->_flushUpdate($update);
      }
    }
    $this->_completeFlush();
  }

  //=========================================================================
  protected function _getTableLayout(){
    if (isset($this->{$this->_primaryKey})) {
      $id = $this->{$this->_primaryKey};
    }
    else {
      $id = -1;
    }
    $sql = 'SELECT * FROM '.$this->_tableName.' WHERE '.
              $this->_primaryKey.' = '.$id;
    // Select an empty record from the database
    $this->__adodbResult = $this->_db->Execute($sql);
  }

  //=========================================================================
  /**
  * @param string $value
  */
  public function setPrimaryKey($value) {
    $this->_primaryKey = $value;

  }

  //=========================================================================
  /**
  * @param string $value
  */
  protected function setTableName($value) {
    $this->_tableName = $value;
  }

}
?>