<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Mediagroup - represents mediagroups information as php object                          **
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
include_once(TTEX_3RDLIBS.'genesis-core/class.item.php');

//***** Mediagroup *************************************************************
/**
//**represents mediagroups information as php object
//** @package    example.teletask
//** @copyright  2006 Andreas Meyer, Sebastian Böttner
//** @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
//** @author Andreas Meyer, Sebastian Böttner
 */
class Mediagroup extends Item {

    /**
     * @var integer
     */
    protected $id;
    /**
     * @var integer
     */
    protected $parentId;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $baseurl;


  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  public function __construct($id = -1, $data = null) {
      $this->setPrimaryKey('id');
      $this->setTableName('mediagroups');

    parent::__construct($id, $data);
  } //end of __construct

  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  protected function _restoreStandardValues() {
    $this->id = -1;
    $this->name = '';
    $this->baseurl= '';
    $this->parentId = 0;

  } //end of _restoreStandardValues

  //=========================================================================
  /**
  * @return int
  */
  public function getID() {
    return intval($this->id);
  } //end of getId

  //=========================================================================
  /**
  * @param int $value
  */
  public function setID($value) {
    $this->id = $value;
  } //end of setId

  //=========================================================================
  /**
  * @return string
  */
  public function getName() {
    return $this->name;
  } //end of getName

  //=========================================================================
  /**
  * @param string $value
  */
  public function setName($value) {
    $this->name = $value;
  } //end of setName

  //=========================================================================
  /**
  * @return string
  */
  public function getBaseUrl() {
    return $this->baseurl;
  } //end of getBaseUrl

  //=========================================================================
  /**
  * @param string $value
  */
  public function setBaseUrl($value) {
    $this->baseurl = $value;
  } //end of setBaseUrl

  //=========================================================================
  /**
  * @return int
  */
  public function getParentID() {
    return intval($this->parentId);
  } //end of getParentId

  //=========================================================================
  /**
  * @param int $value
  */
  public function setParentID($value) {
    $this->parentId = $value;
  } //end of setParentId


} //end of Mediagroup
?>
