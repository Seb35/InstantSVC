<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** queryLecturegroup - queries lecturegroup objects from database        **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** 2006 by Andreas Meyer, Sebastian Böttner			                   **
//**                                                                       **
//** last change: 2006-02-27 Andreas Meyer                                 **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/../constants.php');
require_once(TTEX_3RDLIBS.'genesis-core/class.dbCollection.php');
require_once(TTEX_LIBS.'class.Lecture.php');

//***** queryLecturegroup ********************************************************
/**
* queryLecturegroup - provides basic queries on table lecturegroup of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @webservice
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer
*/
class queryLecturegroup extends DbCollection {

  //=========================================================================
  /**
  * returns All Lecturegroups as Objects from TT database
  *
  * @webmethod
  * @return Lecturegroup[]
  */
  public function getAllLecturegroups() {
    $sql = 'SELECT * FROM lecturegroups';

    $this->_lastResult = $this->_db->Execute($sql);

    $result = $this->_getItemsFromResult();
    return $result;
   }

  //=========================================================================
  /**
   * @param int $id
   * @return Lecturegroup
   */
  public function getLecturegroup($id) {
      $sql = 'SELECT LG.*
			  FROM lecturegroups LG
			  WHERE LG.id='.$id;

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
  * @param Lecturegroup
  * @return void
  */
  public function updateOrAddLecturegroup(Lecturegroup $lecturegroup) {
       $lecturegroup->flush();
  }

  //=========================================================================
  /**
  * Returns an array of strings, index represents lecturegroup id, value the name
  *
  * @webmethod
  *
  * @return String[]
  */
  public function getIdAndNameOfAllLecturegroups() {

	$sql = 'SELECT LG.name, LG.id
            FROM lecturegroups LG';

 	$this->_lastResult = $this->_db->Execute($sql);

 	if (isset($this->_lastResult)) {
		while (!$this->_lastResult->EOF) {

			$item = new Lecturegroup(-1, $this->_lastResult->fields);
			$result[$item->getID()] = $item->getName();
			$this->_lastResult->MoveNext();
		} //end while
	} //end if

 	return $result;
  }

  //=========================================================================
  /**
  * returns an array of lecturegroups which relate to given lecturename
  * @webmethod
  *
  * @param string $lectureName
  * @return Lecturegroup[]
  */
  public function getLecturegroupsByLecture($lectureName) {
      $sql = 'SELECT *
              FROM lecturegroups LG JOIN relation_lecturegroups_lectures RLL ON LG.id = RLL.lecturegroupsId
              WHERE RLL.lecturesId IN (
                                      SELECT L.id
                                      FROM lectures L
                                      WHERE L.name = '.$this->_db->qstr($lectureName).'
									  )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //=========================================================================
  /**
  * returns an array of lecturegroups which relate to given seriesname
  * @webmethod
  *
  * @param string $seriesName
  * @return Lecturegroup[]
  */
  public function getLecturegroupsBySeries($seriesName) {
      $sql = 'SELECT *
              FROM lecturegroups LG JOIN relation_series_lecturegroups RSL ON LG.id = RSL.lecturegroupsId
              WHERE RSL.seriesId IN (
                                   SELECT S.id
                                   FROM series S
                                   WHERE S.name '.$this->_db->qstr($seriesName).'
								   )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //========================================================================
  /**
  * fetches single lecturegroup objects from the db query result and stores them
  * in an array
  *
  * @return Lecturegroup[]
  */
  protected function _getItemsFromResult()
  {
      if (isset($this->_lastResult)) {
			while (!$this->_lastResult->EOF) {
				$item =  new Lecturegroup(-1, $this->_lastResult->fields);
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
  * @return queryLecturegroup
  */
  static public function getInstance($class = 'queryLecturegroup') {
    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    } //end if

    return self::$instance;
  } //end of getInstance
} //end of wsDBCollection

?>
