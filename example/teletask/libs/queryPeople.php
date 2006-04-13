<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** queryPeople - queries people objects from database                          **
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

//***** queryPeople ********************************************************
/**
* queryPeople - provides basic queries on table people of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @webservice
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer
*/
class queryPeople extends DbCollection {

  //=========================================================================
  /**
  * returns All People as Objects from TT database
  *
  * @webmethod
  * @return People[]
  */
  public function getAllPeople() {
    $sql = 'SELECT * FROM people';

    $this->_lastResult = $this->_db->Execute($sql);

    $result = $this->_getItemsFromResult();
    return $result;
   }

  //=========================================================================
  /**
   * @param int $id
   * @return People
   */
  public function getPeople($id) {
      $sql = 'SELECT *
			  FROM people P
			  WHERE P.id='.$id;

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
  * @param People
  * @return void
  */
  public function updateOrAddPeople(People $people) {
       $people->flush();
  }

  //=========================================================================
  /**
  * Returns an array of strings, index represents people id, value the name
  *
  * @webmethod
  *
  * @return String[]
  */
  public function getIdAndNameOfAllPeople() {

	$sql = 'SELECT P.name, P.id
            FROM people P';

 	$this->_lastResult = $this->_db->Execute($sql);

 	if (isset($this->_lastResult)) {
		while (!$this->_lastResult->EOF) {

			$item = new People(-1, $this->_lastResult->fields);
			$result[$item->getID()] = $item->getName();
			$this->_lastResult->MoveNext();
		} //end while
	} //end if

 	return $result;
  }

  //=========================================================================
  /**
  * returns an array of people which relate to given seriesname
  * @webmethod
  *
  * @param string $seriesName
  * @return People[]
  */
  public function getAuthorBySeries($seriesName) {
      $sql = 'SELECT *
              FROM people P JOIN relation_authors_series_people RASP ON P.id = RASP.peopleId
              WHERE RASP.seriesId IN (
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
  * returns an array of people which relate to given lecturename
  * @webmethod
  *
  * @param string $lectureName
  * @return People[]
  */
  public function getAuthorByLectures($lectureName) {
      $sql = 'SELECT P.name, P.id
              FROM people P JOIN relation_authors_lectures_people RALP ON P.id = RALP.peopleId
              WHERE RALP.lecturesId IN (
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
  * returns an array of people which relate to given seriesname
  * @webmethod
  *
  * @param string $seriesName
  * @return People[]
  */
  public function getContactsBySeries($seriesName) {
      $sql = 'SELECT *
              FROM people P JOIN relation_contacts_series_people RCSP ON P.id = RCSP.peopleId
              WHERE RCSP.seriesId IN (
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
  * returns an array of people which relate to given lecturename
  * @webmethod
  *
  * @param string $lectureName
  * @return People[]
  */
  public function getSpeakerByLectures($lectureName) {
      $sql = 'SELECT P.name, P.id
              FROM people P JOIN relation_speakers_lectures_people RSLP ON P.id = RSLP.peopleId
              WHERE RSLP.lecturesId IN (
									   SELECT L.id
                                       FROM lectures L
									   WHERE L.name = '.$this->_db->qstr($lectureName).'
									   )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //========================================================================
  /**
  * fetches single people objects from the db query result and stores them
  * in an array
  *
  * @return People[]
  */
  protected function _getItemsFromResult()
  {
      if (isset($this->_lastResult)) {
			while (!$this->_lastResult->EOF) {
				$item =  new People(-1, $this->_lastResult->fields);
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
  * @return queryPeople
  */
  static public function getInstance($class = 'queryPeople') {
    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    } //end if

    return self::$instance;
  } //end of getInstance
} //end of wsDBCollection

?>
