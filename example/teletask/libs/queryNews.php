<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** queryNews - queries news objects from database                  **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** 2006 by Andreas Meyer, Sebastian Böttner                                  **
//**                                                                       **
//** last change: 2006-02-27 Andreas Meyer                                 **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/../constants.php');
require_once(TTEX_3RDLIBS.'genesis-core/class.dbCollection.php');
require_once(TTEX_LIBS.'class.Lecture.php');

//***** queryNews ********************************************************
/**
* queryNews - provides basic queries on table news of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @webservice
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer
*/

class queryNews extends DbCollection{
  //=========================================================================
  /**
  * returns All News as Objects from TT database
  *
  * @webmethod
  * @return News[]
  */
   public function getAllNews() {
      $sql = 'SELECT N.heading, N.id
              FROM news N';

     $this->_lastResult = $this->_db->Execute($sql);

     $result = $this->_getItemsFromResult();
     return $result;
  }

   //=========================================================================
   /**
   * @webmethod
   * @param int $id
   * @return News
   */
  public function getNews($id) {
      $sql = 'SELECT * FROM news N WHERE N.id='.$id;

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
  * @param News $news
  * @return void
  */
  public function updateOrAddNews(News $news) {
       $news->flush();
  }

  //=========================================================================
  /**
  * @webmethod
  * @param string $language
  * @return News[]
  */
  public function getNewsByLanguage($language) {
      $sql = 'SELECT N.heading, N.id
              FROM news N
              WHERE N.languagesId IN (
                                     SELECT LANG.id
                                     FROM languages LANG
                                     WHERE LANG.name ='.$this->_db->qstr($language).'
                                     )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //=========================================================================
  /**
  * @webmethod
  * @param date $newsDate
  * @return News[]
  */
  public function getNewsByNewsdate($newsDate) {
      $sql = 'SELECT N.heading, N.id
              FROM news N
              WHERE N.newsdate = '.$this->_db->qstr($newsDate).'
              )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //=========================================================================
  /**
  * fetches single news objects from the db query result and stores them
  * in an array
  *
  * @return News[]
  */
   protected function _getItemsFromResult()
  {
      if (isset($this->_lastResult)) {
                        while (!$this->_lastResult->EOF) {
                                $item =  new dbNews(-1, $this->_lastResult->fields);
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
   * @return queryNews
   */
  static public function getInstance($class = 'queryNews') {
    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    } //end if

    return self::$instance;
  } //end of getInstance
} //end of wsDBCollection
?>
