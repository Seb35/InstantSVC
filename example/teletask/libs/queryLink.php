<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** queryLink - queries link objects from database                          **
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

//***** queryLink ********************************************************
/**
* queryLink - provides basic queries on table links of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @webservice
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer
*/
class queryLink extends DbCollection {

  //=========================================================================
  /**
  * returns All Link as Objects from TT database
  *
  * @webmethod
  * @return Link[]
  */
  public function getAllLinks() {
    $sql = 'SELECT * FROM links';

    $this->_lastResult = $this->_db->Execute($sql);

    $result = $this->_getItemsFromResult();
    return $result;
   }

  //=========================================================================
  /**
   * @param int $id
   * @return Link
   */
  public function getLink($id) {
      $sql = 'SELECT *
			  FROM links LINK
			  WHERE LINK.id='.$id;

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
  * @param Link
  * @return void
  */
  public function updateOrAddLink(Link $link) {
       $link->flush();
  }

  //=========================================================================
  /**
  * Returns an array of strings, index represents link id, value the name
  *
  * @webmethod
  *
  * @return String[]
  */
  public function getIdAndNameOfAllLinks() {

	$sql = 'SELECT LINK.name, LINK.id
            FROM links LINK';

 	$this->_lastResult = $this->_db->Execute($sql);

 	if (isset($this->_lastResult)) {
		while (!$this->_lastResult->EOF) {

			$item = new Link(-1, $this->_lastResult->fields);
			$result[$item->getID()] = $item->getName();
			$this->_lastResult->MoveNext();
		} //end while
	} //end if

 	return $result;
  }

  //=========================================================================
  /**
  * returns an array of links which relate to given linkgroupname
  * @webmethod
  *
  * @param string $linkgroupName
  * @return Link[]
  */
  public function getLinksByLinkgroup($linkgroupName) {
      $sql = 'SELECT *
              FROM links LINK JOIN relation_linkgroups_links RLGL ON LINK.id = RLGL.linksId
              WHERE RLGL.linkgroupsId IN (
										 SELECT LGRP.id
										 FROM linkgroups LGRP
										 WHERE LGRP.name = '.$this->_db->qstr($linkgroupName).'
										 )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //========================================================================
  /**
  * fetches single link objects from the db query result and stores them
  * in an array
  *
  * @return Link[]
  */
  protected function _getItemsFromResult()
  {
      if (isset($this->_lastResult)) {
			while (!$this->_lastResult->EOF) {
				$item =  new Link(-1, $this->_lastResult->fields);
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
  * @return queryLink
  */
  static public function getInstance($class = 'queryLink') {
    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    } //end if

    return self::$instance;
  } //end of getInstance
} //end of wsDBCollection

?>
