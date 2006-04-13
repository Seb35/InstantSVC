<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** queryLecture - queries lecture objects from database                          **
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

//***** queryLecture ********************************************************
/**
* queryLecture - provides basic queries on table lectures of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @webservice
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer
*/
class queryLecture extends DbCollection {

  //=========================================================================
  /**
  * returns All Lectures as Objects from TT database
  *
  * @webmethod
  * @return Lecture[]
  */
  public function getAllLectures() {
    $sql = 'SELECT * FROM lectures';

    $this->_lastResult = $this->_db->Execute($sql);

    $result = $this->_getItemsFromResult();
    return $result;
   }

   //=========================================================================
   /**
   * @webmethod
   * @param int $id
   * @return Lecture
   */
  public function getLecture($id) {
      $sql = 'SELECT L.* FROM lectures L WHERE L.id='.$id;

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
  * @param Lecture
  * @return void
  */
  public function updateOrAddLecture(Lecture $lecture) {
       $lecture->flush();
  }

  //=========================================================================
  /**
  * Returns an array of strings, index represents lecture id, value the name
  *
  * @webmethod
  *
  * @return String[]
  */
  public function getIdAndNameOfAllLectures() {

	$sql = 'SELECT L.id, L.name FROM lectures L';

 	$this->_lastResult = $this->_db->Execute($sql);

 	if (isset($this->_lastResult)) {
		while (!$this->_lastResult->EOF) {

			$item = new Lecture(-1, $this->_lastResult->fields);
			$result[$item->getID()] = $item->getName();
			$this->_lastResult->MoveNext();
		} //end while
	} //end if

 	return $result;
  }

  //=========================================================================
  /**
  * returns the name as string of a lecture with given id
  *
  * @webmethod
  *
  * @param Integer $id
  * @return String
  */
  public function getLectureNameById($id) {
  	$foo = new Lecture($id, null);

  	return $foo->getName();
  }

  //=========================================================================
  /**
  * takes an array of strings and returns the abstract for each lecture
  * with its name in the array
  *
  * @webmethod
  *
  * @param String[] $name
  * @return String[]
  */
  public function getAbstractbyName($name) {


	$sql = 'SELECT L.abstract, L.name FROM lectures L';
	$this->_lastResult = $this->_db->Execute($sql);

	if (isset($this->_lastResult)) {
		while (!$this->_lastResult->EOF) {
			$item =  new Lecture(-1, $this->_lastResult->fields);
			foreach($name as $key => $value) {
				if ($value == $item->getName()) {
					$result[$item->getId()] = $item->getAbstract();
				}
			}
			$this->_lastResult->MoveNext();
		} //end while
	} //end if
	return $result;
  }

  //=========================================================================
  /**
  * fetches lecture for given id and alters its name according to given
  * string then flushes the changes back to database
  *
  * @webmethod
  *
  * @param integer $id
  * @param string $name
  * @return void
  */
  public function updateLectureNameById($id, $name) {
    $lecture = new Lecture($id, null);
    $lecture->setName($name);
    $lecture->flush();
  }

  //=========================================================================
  /**
  * returns an array of lectures which relate to given lecturegroupname
  * @webmethod
  *
  * @param string $lecturegroupName
  * @return Lecture[]
  */
  public function getLecturesByLecturegroups($lecturegroupName) {
      $sql = 'SELECT *
		  FROM lectures L JOIN relation_lecturegroups_lectures
		  RLL ON L.id = RLL.lecturesId
		  WHERE RLL.lecturegroupsId IN (
			SELECT LG.id
			FROM lecturegroups LG
			WHERE LG.name = '.$this->_db->qstr($lecturegroupName).'
			)';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //=========================================================================
  /**
  * returns an array of lectures, written by given author
  *
  * @webmethod
  *
  * @param string $authorName
  * @return Lecture[]
  */
  public function getLecturesByAuthor($authorName) {
      $sql = 'SELECT L.name, L.id
	      FROM lectures L JOIN relation_authors_lectures_people
		RALP ON L.id = RALP.lecturesId
	      WHERE RALP.peopleId IN (
				 SELECT P.id
				 FROM people P
				 WHERE P.name = '.$this->_db->qstr($authorName).'
				 )';


      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }
  //=========================================================================
  /**
  * returns an array of lectures, spoken by given person
  *
  * @webmethod
  *
  * @param string $speakerName
  * @return Lecture[]
  */
  public function getLecturesBySpeaker($speakerName) {
      $sql = 'SELECT *
	      FROM lectures L JOIN relation_speakers_lectures_people
		RSLP ON L.id = RSLP.lecturesId
	      WHERE RSLP.peopleId IN (
				 SELECT P.id
				 FROM people P
				 WHERE P.name = '.$this->_db->qstr($speakerName).'
				 )';


      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //========================================================================
  /**
  * returns an array of Lectures of a certain given language
  *
  * @webmethod
  *
  * @param string $language
  * @return Lecture[]
  */
  public function getLecturesByLanguage($language) {
      $sql = 'SELECT *
	      FROM lectures L
	      WHERE L.languagesId IN (
			     SELECT LANG.id
			     FROM languages LANG
			     WHERE LANG.name = '.$this->_db->qstr($language).'
			     )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //========================================================================
  /**
  * fetches single lecture objects from the db query result and stores them
  * in an array
  *
  * @return Lecture[]
  */
  protected function _getItemsFromResult()
  {
      if (isset($this->_lastResult)) {
			while (!$this->_lastResult->EOF) {
				$item =  new Lecture(-1, $this->_lastResult->fields);
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
  * @return queryLecture
  */
  static public function getInstance($class = 'queryLecture') {
    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    } //end if

    return self::$instance;
  } //end of getInstance
} //end of wsDBCollection

?>
