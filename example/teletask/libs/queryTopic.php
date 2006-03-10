<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** queryTopic - queries topic objects from database                  **
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

//***** queryTopic ********************************************************
/**
* queryTopic - provides basic queries on table topics of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @webservice
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer
*/
class queryTopic extends DbCollection {

  //=========================================================================
  /**
  * returns All Topic as Objects from TT database
  *
  * @webmethod
  * @return Topic[]
  */
  public function getAllTopics() {
    $sql = 'SELECT * FROM topics';

    $this->_lastResult = $this->_db->Execute($sql);

    $result = $this->_getItemsFromResult();
    return $result;
   }

  //=========================================================================
  /**
   * @param int $id
   * @return Topic
   */
  public function getTopic($id) {
      $sql = 'SELECT *
			  FROM topics T
			  WHERE T.id='.$id;

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
  * @param Topic
  * @return void
  */
  public function updateOrAddPeople(Topic $Topic) {
       $topic->flush();
  }

  //=========================================================================
  /**
  * Returns an array of strings, index represents topic id, value the name
  *
  * @webmethod
  *
  * @return String[]
  */
  public function getIdAndNameOfAllTopics() {

	$sql = 'SELECT T.id, T.name FROM topics T';

 	$this->_lastResult = $this->_db->Execute($sql);

 	if (isset($this->_lastResult)) {
		while (!$this->_lastResult->EOF) {

			$item = new Topic(-1, $this->_lastResult->fields);
			$result[$item->getID()] = $item->getName();
			$this->_lastResult->MoveNext();
		} //end while
	} //end if

 	return $result;
  }

  //=========================================================================
  /**
  * returns an array of topic which relate to given seriesname
  * @webmethod
  *
  * @param string $seriesName
  * @return Topic[]
  */
  public function getTopicBySeries($seriesName) {
      $sql = 'SELECT T.name, T.id
              FROM topics T JOIN relation_series_topics RST ON T.id = RST.seriesId
              WHERE RST.seriesId IN (
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
  * returns an array of topic which relate to given languagename
  * @webmethod
  *
  * @param string $languageName
  * @return Topic[]
  */
  public function getTopicsByLanguage($languageName) {
      $sql = 'SELECT T.name, T.id
              FROM topics T JOIN languages LANG ON T.id = LANG.id
              WHERE LANG.id IN (
							   SELECT LANG.id
                               FROM languages LANG
                               WHERE LANG.name = '.$this->_db->qstr($languageName).'
							   )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //========================================================================
  /**
  * fetches single topic objects from the db query result and stores them
  * in an array
  *
  * @return Topic[]
  */
  protected function _getItemsFromResult()
  {
      if (isset($this->_lastResult)) {
			while (!$this->_lastResult->EOF) {
				$item =  new Topic(-1, $this->_lastResult->fields);
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
  * @return queryTopic
  */
  static public function getInstance($class = 'queryTopic') {
    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    } //end if

    return self::$instance;
  } //end of getInstance
} //end of wsDBCollection

?>
