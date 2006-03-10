<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** queryLanguage - queries language objects from database                **
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

//***** queryLanguage ********************************************************
/**
* queryLanguage - provides basic queries on table language of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @webservice
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer
*/
class queryLanguage extends DbCollection {

  //=========================================================================
  /**
   * @param int $id
   * @return Language
   */
  public function getLanguage($id) {
      $sql = 'SELECT *
			  FROM languages LANG
			  WHERE LANG.id='.$id;

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
  * @param Language
  * @return void
  */
  public function updateOrAddLanguage(Language $language) {
       $language->flush();
  }

  //=========================================================================
  /**
  * returns an array of language which relate to given seriesname
  * @webmethod
  *
  * @param string $seriesName
  * @return Language[]
  */
  public function getLanguageBySeries($seriesName) {
      $sql = 'SELECT LANG.name, LANG.id
              FROM languages LANG
              WHERE LANG.id IN (
                               SELECT S.languagesId
                               FROM series S
                               WHERE S.name = '.$this->_db->qstr($seriesName).'
							   )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //=========================================================================
  /**
  * returns an array of language which relate to given lecturename
  * @webmethod
  *
  * @param string $lectureName
  * @return Language[]
  */
  public function getAuthorByLectures($lectureName) {
      $sql = 'SELECT LANG.name, LANG.id
              FROM languages LANG
              WHERE LANG.id IN (
							   SELECT L.languagesId
                               FROM lectures L
                               WHERE L.name = '.$this->_db->qstr($lectureName).'
							   )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //========================================================================
  /**
  * fetches single language objects from the db query result and stores them
  * in an array
  *
  * @return Language[]
  */
  protected function _getItemsFromResult()
  {
      if (isset($this->_lastResult)) {
			while (!$this->_lastResult->EOF) {
				$item =  new Language(-1, $this->_lastResult->fields);
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
  * @return queryLanguage
  */
  static public function getInstance($class = 'queryLanguage') {
    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    } //end if

    return self::$instance;
  } //end of getInstance
} //end of wsDBCollection

?>
