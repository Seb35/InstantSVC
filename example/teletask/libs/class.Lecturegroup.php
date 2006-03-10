<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Lecturegroup - represents lecturegroups information as php object     **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** 2005 by Andreas Meyer, Sebastian Böttner, Stefan Marr                 **
//**                                                                       **
//** last change: 2005-02-26 Sebastian Böttner                             **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/../constants.php');
include_once(TTEX_3RDLIBS.'genesis-core/class.item.php');

//***** Lecturegroup *************************************************************
/**
 * @package    example.teletask
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class Lecturegroup extends Item {

    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $showName;


  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  public function __construct($id = -1, $data = null) {
      $this->setPrimaryKey('id');
      $this->setTableName('lecturegroups');

    parent::__construct($id, $data);
  } //end of __construct

  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  protected function _restoreStandardValues() {
    $this->id = -1;
    $this->name = '';
    $this->showName = 'y';

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
  public function getShowName() {
    return $this->showName;
  } //end of geShowName

  //=========================================================================
  /**
  * @param string $value
  */
  public function setShowName($value) {
    $this->showName = $value;
  } //end of setShowName


} //end of Lecturegroup
?>
