<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Topic - represents topic information as php object                    **
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


//***** Topic *************************************************************
/**
 * @package    example.teletask
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class Topic extends Item {

    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;


  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  public function __construct($id = -1, $data = null) {
      $this->setPrimaryKey('id');
      $this->setTableName('topic');

    parent::__construct($id, $data);
  } //end of __construct

  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  protected function _restoreStandardValues() {
    $this->id = -1;
    $this->name = '';

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

} //end of Topic
?>
