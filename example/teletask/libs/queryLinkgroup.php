<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** queryLinkgroup - queries linkgroup objects from database                          **
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

//***** queryLinkgroup ********************************************************
/**
* queryLinkgroup - provides basic queries on table linkgroup of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @webservice
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer
*/
class queryLinkgroup extends DbCollection {

  //=========================================================================
  /**
  * returns All Linkgroups as Objects from TT database
  *
  * @webmethod
  * @return Linkgroup[]
  */
  public function getAllLinkgroups() {
    $sql = 'SELECT * FROM linkgroups';

    $this->_lastResult = $this->_db->Execute($sql);

    $result = $this->_getItemsFromResult();
    return $result;
   }

  //=========================================================================
  /**
   * @param int $id
   * @return Linkgroup
   */
  public function getLinkgroup($id) {
      $sql = 'SELECT LGRP.*
			  FROM linkgroups LGRP
			  WHERE LGRP.id='.$id;

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

  * @param Linkgroup
  * @return void
  */
  public function updateOrAddLinkgroup(Linkgroup $linkgroup) {
       $linkgroup->flush();
  }

  //=========================================================================
  /**
  * Returns an array of strings, index represents linkgroup id, value the name
  *
  * @webmethod
  *
  * @return String[]
  */
  public function getIdAndNameOfAllLinkgroups() {

	$sql = 'SELECT LGRP.name, LGRP.id
            FROM linkgroups LGRP';

 	$this->_lastResult = $this->_db->Execute($sql);

 	if (isset($this->_lastResult)) {
		while (!$this->_lastResult->EOF) {

			$item = new Linkgroup(-1, $this->_lastResult->fields);
			$result[$item->getID()] = $item->getName();
			$this->_lastResult->MoveNext();
		} //end while
	} //end if

 	return $result;
  }

  //=========================================================================
  /**
  * returns an array of linkgroups which relate to given lecturename
  * @webmethod
  *
  * @param string $lectureName
  * @return Linkgroup[]
  */
  public function getLecturegroupsByLecture($lectureName) {
      $sql = 'SELECT *
              FROM linkgroups LGRP JOIN relation_lectures_linkgroups RLLG ON LGRP.id = RLLG.linkgroupsId
              WHERE RLLG.lecturesId IN (
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
  * returns an array of linkgoups which relate to given linkname
  * @webmethod
  *
  * @param string $linkName
  * @return Linkgroup[]
  */
  public function getLinkgroupsByLink($linkName) {
      $sql = 'SELECT *
              FROM linkgroups LGRP JOIN relation_linkgroups_links RLGL ON LGRP.id = RLGL.linkgroupsId
              WHERE RLGL.linksId IN (
                                    SELECT LINK.id
                                    FROM links LINK
                                    WHERE LINK.name = '.$this->_db->qstr($linkName).'
						  		    )';

      $this->_lastResult = $this->_db->Execute($sql);
      $result = $this->_getItemsFromResult();
      return $result;
  }

  //=========================================================================
  /**
  * returns an array of linkgroups which relate to given seriesname
  * @webmethod
  *
  * @param string $seriesName
  * @return Linkgroup[]
  */
  public function getLinkgroupsBySeries($seriesName) {
      $sql = 'SELECT *
              FROM linkgroups LGRP JOIN relation_series_linkgroups RSLG ON LGRP.id = RSLG.linkgroupsId
              WHERE RSLG.seriesId IN (
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
  * fetches single linkgroup objects from the db query result and stores them
  * in an array
  *
  * @return Linkgroup[]
  */
  protected function _getItemsFromResult()
  {
      if (isset($this->_lastResult)) {
			while (!$this->_lastResult->EOF) {
				$item =  new Linkgroup(-1, $this->_lastResult->fields);
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
  * @return queryLinkgroup
  */
  static public function getInstance($class = 'queryLinkgroup') {
    if (!isset(self::$instance)) {
      $class = __CLASS__;
      self::$instance = new $class;
    } //end if

    return self::$instance;
  } //end of getInstance
} //end of wsDBCollection

?>
