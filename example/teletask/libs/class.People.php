<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** People - represents people information as php object                  **
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


//***** People *************************************************************
/**
 * @package    example.teletask
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class People extends Item {

    /**
     * @var integer
     */
    protected $id;
    /**
     * @var string
     */
    protected $homepageurl;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $emailurl;


  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  public function __construct($id = -1, $data = null) {
      $this->setPrimaryKey('id');
      $this->setTableName('people');

    parent::__construct($id, $data);
  } //end of __construct

  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  protected function _restoreStandardValues() {
    $this->id = -1;
    $this->name = '';
    $this->emailurl= '';
    $this->homepageurl = '';

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
  public function getEmailUrl() {
    return $this->emailurl;
  } //end of getEmailUrl

  //=========================================================================
  /**
  * @param string $value
  */
  public function setEmailUrl($value) {
    $this->emailurl = $value;
  } //end of setEmailUrl

  //=========================================================================
  /**
  * @return string
  */
  public function getHomePageUrl() {
    return intval($this->homepageurl);
  } //end of getHomePageUrl

  //=========================================================================
  /**
  * @param string $value
  */
  public function setHomePageUrl($value) {
    $this->homepageurl = $value;
  } //end of setHomePageUrl


} //end of People
?>
