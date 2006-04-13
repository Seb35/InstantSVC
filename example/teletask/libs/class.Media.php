<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Media - represents media information as php object                          **
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

//***** Media *************************************************************
/**
//**represents media information as php object
//** @package    example.teletask
//** @copyright  2006 Andreas Meyer, Sebastian Böttner
//** @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
//** @author Andreas Meyer, Sebastian Böttner
 */
class Media extends Item {

    /**
     * @var integer
     */
    protected $id;
    /**
     * @var integer
     */
    protected $mediagroupId;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $url;


  //=========================================================================
  /**
  * Standard Konstruktor
  * 
  * @param int $id
  * @param string[] $data
  */

  public function __construct($id = -1, $data = null) {
      $this->setPrimaryKey('id');
      $this->setTableName('media');

    parent::__construct($id, $data);
  } //end of __construct

  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  protected function _restoreStandardValues() {
    $this->id = -1;
    $this->name = '';
    $this->url = '';
    $this->mediagroupId = 0;

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
  public function getURL() {
    return $this->url;
  } //end of getURL

  //=========================================================================
  /**
  * @param string $value
  */
  public function setURL($value) {
    $this->url = $value;
  } //end of setURL

  //=========================================================================
  /**
  * @return int
  */
  public function getMediaGroupId() {
    return intval($this->mediagroupId);
  } //end of getMediaGroupId

  //=========================================================================
  /**
  * @param int $value
  */
  public function setMediaGroupId($value) {
    $this->mediagroupId = $value;
  } //end of setMediaGroupId


} //end of media
?>
