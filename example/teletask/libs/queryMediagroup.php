<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** queryMediagroup - queries mediagroup objects from database                  **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** 2006 by Andreas Meyer, Sebastian Böttner			               **
//**                                                                       **
//** last change: 2006-02-27 Andreas Meyer                                 **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/../constants.php');
require_once(TTEX_3RDLIBS.'genesis-core/class.dbCollection.php');
require_once(TTEX_LIBS.'class.Lecture.php');

//***** queryMediagroups ********************************************************
/**
* queryMediagroups - provides basic queries on table mediagroups of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @webservice
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer
*/
class queryMediagroup extends DbCollection {

  //=========================================================================
  /**
  * returns All Mediagroups as Objects from TT database
  *
  * @webmethod
  * @return Mediagroup[]
  */
  public function getAllMediagroups() {
    $sql = 'SELECT * FROM mediagroups';

    $this->_lastResult = $this->_db->Execute($sql);

    $result = $this->_getItemsFromResult();
    return $result;
   }

  //=========================================================================
  /**
   * @param int $id
   * @return Mediagroup
   */
  public function getMediagroup($id) {
      $sql = 'SELECT *
			  FROM mediagroups MG
			  WHERE MG.id='.$id;

     $this->_lastResult = $this->_db->Execute($sql);

     $result = $this->_getItemsFromResult();

     $res = array_pop($result);
     return $res;
  }

  //=========================================================================
  /**
  * Stores new (id = -1) sets into database or updates old entries (valid id)
  *
  * @webmethod
  * @param Mediagroup $mediagroup
  * @return void
  */
  public function updateOrAddMediagroup(Mediagroup $mediagroup) {
       $mediagroup->flush();
  }

  //=========================================================================
  /**
  * Returns an array of strings, index represents mediagroup id, value the name
  *
  * @webmethod
  *
  * @return String[]
  */
  public function getIdAndNameOfAllMediagroups() {

	$sql = 'SELECT MG.id, MG.name FROM mediagroups MG';

 	$this->_lastResult = $this->_db->Execute($sql);

 	if (isset($this->_lastResult)) {
		while (!$this->_lastResult->EOF) {

			$item = new Mediagroup(-1, $this->_lastResult->fields);
			$result[$item->getID()] = $item->getName();
			$this->_lastResult->MoveNext();
		} //end while
	} //end if

 	return $result;
  }

  //=========================================================================
  /**
  * returns an array of mediagroup which relate to given medianame
  * @webmethod
  *
  * @param string $mediaName
  * @return Mediagroup[]
  */
  public function getMediagroupByMedia($mediaName) {
      $sql = 'SELECT MG.name, MG.id
              FROM mediagroups MG JOIN media M
              WHERE M.id IN (
                            SELECT M.id
                            FROM media M
                            WHERE M.name = '.$this->_db->qstr($mediaName).'
						     )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //=========================================================================
  /**
  * returns an array of mediagroup which relate to given seriesname
  * @webmethod
  *
  * @param string $mediagroupName
  * @return Mediagroup[]
  */
  public function getParentMediagroupByMediagroup($mediagroupName) {
      $sql = 'SELECT MG.parentId
              FROM mediagroups MG
              WHERE MG.id IN (
                             SELECT MG.id
                             FROM mediagroups MG
                             WHERE MG.name = '.$this->_db->qstr($mediagroupName).'
						     )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //========================================================================
  /**
  * fetches single mediagroup objects from the db query result and stores them
  * in an array
  *
  * @return Mediagroup[]
  */
  protected function _getItemsFromResult()
  {
      if (isset($this->_lastResult)) {
			while (!$this->_lastResult->EOF) {
				$item =  new Mediagroup(-1, $this->_lastResult->fields);
				$this->Items[$item->getId()] = $item;
				$this->_lastResult->MoveNext();
			} //end while
		} //end if

    return $this->Items;
  }
    private static $instance;

  //=========================================================================
  /**
  * get singleton instance
  * @return queryMediagroup
  */
  static public function getInstance($class = 'queryMediagroup') {
    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    } //end if

    return self::$instance;
  } //end of getInstance
} //end of wsDBCollection

?>
