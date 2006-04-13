<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** queryMedia - queries media objects from database                          **
//**                                                                       **
//** project: Web Services Description Generator                    **
//**                                                                       **
//** @package    example.teletask
//** @copyright  2006 Andreas Meyer, Sebastian Böttner
//** @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
//** @author Andreas Meyer, Sebastian Böttner                 **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/../constants.php');
require_once(TTEX_3RDLIBS.'genesis-core/class.dbCollection.php');
require_once(TTEX_LIBS.'class.Lecture.php');

//***** queryMedia ********************************************************
/**
* queryMedia - provides basic queries on table Media of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @webservice
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer
*/
class queryMedia extends DbCollection {

  //=========================================================================
  /**
  * returns All Media as Objects from TT database
  *
  * @webmethod
  * @return Media[]
  */
  public function getAllMedia() {
    $sql = 'SELECT * FROM media';

    $this->_lastResult = $this->_db->Execute($sql);

    $result = $this->_getItemsFromResult();
    return $result;
   }

  //=========================================================================
  /**
   * @param int $id
   * @return Media
   */
  public function getMedia($id) {
      $sql = 'SELECT *
			  FROM media M
			  WHERE M.id='.$id;

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
  * @param Media
  * @return void
  */
  public function updateOrAddMedia(Media $media) {
       $media->flush();
  }

  //=========================================================================
  /**
  * Returns an array of strings, index represents media id, value the name
  *
  * @webmethod
  *
  * @return String[]
  */
  public function getIdAndNameOfAllMedia() {

	$sql = 'SELECT M.id, M.name FROM media M';

 	$this->_lastResult = $this->_db->Execute($sql);

 	if (isset($this->_lastResult)) {
		while (!$this->_lastResult->EOF) {

			$item = new Media(-1, $this->_lastResult->fields);
			$result[$item->getID()] = $item->getName();
			$this->_lastResult->MoveNext();
		} //end while
	} //end if

 	return $result;
  }

  //=========================================================================
  /**
  * returns an array of media which relate to given seriesname
  * @webmethod
  *
  * @param string $seriesName
  * @return Media[]
  */
  public function getMediaBySeries($seriesName) {
      $sql = 'SELECT M.name, M.id
              FROM media M JOIN series S
              WHERE S.id IN (
                            SELECT S.id
                            FROM series S
                            WHERE S.name = '.$this->_db->qstr($seriesName).'
									)';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //=========================================================================
  /**
  * returns an array of topic which relate to given lecturename
  * @webmethod
  *
  * @param string $lectureName
  * @return Topic[]
  */
  public function getTopicsByLecture($lectureName) {
      $sql = 'SELECT M.name, M.id
              FROM media M JOIN lectures L
              WHERE L.id IN (
                            SELECT L.id
                            FROM series L
                            WHERE L.name = '.$this->_db->qstr($lectureName).'
							   )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //========================================================================
  /**
  * fetches single media objects from the db query result and stores them
  * in an array
  *
  * @return Media[]
  */
  protected function _getItemsFromResult()
  {
      if (isset($this->_lastResult)) {
			while (!$this->_lastResult->EOF) {
				$item =  new Media(-1, $this->_lastResult->fields);
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
  * @return queryMedia
  */
  static public function getInstance($class = 'queryMedia') {
    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    } //end if

    return self::$instance;
  } //end of getInstance
} //end of wsDBCollection

?>
