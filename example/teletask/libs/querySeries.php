<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** querySeries - queries series objects from database                  **
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

//***** querySeries ********************************************************
/**
* querySeries - provides basic queries on table Media of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @webservice
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer
*/
class querySeries extends DbCollection {

  //=========================================================================
  /**
  * returns All Series as Objects from TT database
  *
  * @webmethod
  * @returnSeries[]
  */
  public function getAllSeries() {
    $sql = 'SELECT * FROM series';

    $this->_lastResult = $this->_db->Execute($sql);

    $result = $this->_getItemsFromResult();
    return $result;
   }

  //=========================================================================
  /**
   * @param int $id
   * @return Series
   */
  public function getSeries($id) {
      $sql = 'SELECT *
			  FROM series S
			  WHERE S.id='.$id;

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
  * @param Series
  * @return void
  */
  public function updateOrAddSeries(Series $series) {
       $series->flush();
  }

  //=========================================================================
  /**
  * Returns an array of strings, index represents string id, value the name
  *
  * @webmethod
  *
  * @return String[]
  */
  public function getIdAndNameOfAllSeries() {

	$sql = 'SELECT S.id, S.name FROM series M';

 	$this->_lastResult = $this->_db->Execute($sql);

 	if (isset($this->_lastResult)) {
		while (!$this->_lastResult->EOF) {

			$item = new Series(-1, $this->_lastResult->fields);
			$result[$item->getID()] = $item->getName();
			$this->_lastResult->MoveNext();
		} //end while
	} //end if

 	return $result;
  }

  //=========================================================================
  /**
  * returns an array of series which relate to given topicname
  * @webmethod
  *
  * @param string $topicName
  * @return Series[]
  */
  public function getSeriesByTopic($topicName) {
      $sql = 'SELECT S.name, S.id
              FROM series S JOIN relation_series_topics RST ON S.id = RST.seriesId
              WHERE RST.topicsId IN (
                                    SELECT T.id
                                    FROM topics T
                                    WHERE T.name = '.$this->_db->qstr($seriesName).'
									)';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //=========================================================================
  /**
  * returns an array of series which relate to given languagename
  * @webmethod
  *
  * @param string $languageName
  * @return Series[]
  */
  public function getSeriesByLanguage($languageName) {
      $sql = 'SELECT S.name, S.id
			  FROM series S
              WHERE S.languagesId IN (
									 SELECT LANG.id
									 FROM languages LANG
									 WHERE LANG.name = '.$this->_db->qstr($languageName).'
									 )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //=========================================================================
  /**
  * returns an array of series which relate to given lecturename
  * @webmethod
  *
  * @param string $lectureName
  * @return Series[]
  */
  public function getSeriesByLecture($lectureName) {
      $sql = 'SELECT S.name, S.id
              FROM series S JOIN lecturestatus LS ON S.id = LS.seriesId
              WHERE LS.lecturesId IN (
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
  * returns an array of series which relate to given lecturegroupname
  * @webmethod
  *
  * @param string $lecturegroupName
  * @return Series[]
  */
  public function getSeriesByLecturegroup($lecturegroupName) {
      $sql = 'SELECT S.name, S.id
              FROM series S JOIN relation_series_lecturegroups RSLGRP ON S.id = RSLGRP.seriesId
              WHERE RSLGRP.lecturegroupsId IN (
                                     SELECT LGRP.id
                                     FROM lecturegroups LGRP
                                     WHERE LGRP.name = '.$this->_db->qstr($lecturegroupName).'
									 )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //========================================================================
  /**
  * fetches single series objects from the db query result and stores them
  * in an array
  *
  * @return Series[]
  */
  protected function _getItemsFromResult()
  {
      if (isset($this->_lastResult)) {
			while (!$this->_lastResult->EOF) {
				$item =  new Series(-1, $this->_lastResult->fields);
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
  static public function getInstance($class = 'querySeries') {
    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    } //end if

    return self::$instance;
  } //end of getInstance
} //end of wsDBCollection

?>
