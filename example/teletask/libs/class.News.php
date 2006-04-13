<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** News - represents news information as php object                          **
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

require_once(dirname(__FILE__).'/../constants.php');
include_once(TTEX_3RDLIBS.'genesis-core/class.item.php');


//***** News *************************************************************
/**
//**represents lecture information as php object
//** @package    example.teletask
//** @copyright  2006 Andreas Meyer, Sebastian Böttner
//** @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
//** @author Andreas Meyer, Sebastian Böttner
 */
class News extends Item {

  /**
   * @var int
   */
  protected $id;
  /**
   * @var string
   */
  protected $newsdate;
  /**
   * @var string
   */
  protected $heading;
  /**
   * @var string
   */
  protected $abstract;
  /**
   * @var string
   */
  protected $abstracthtml;
  /**
   * @var string
   */
  protected $linkurl;
  /**
   * @var int
   */
  protected $languagesId;

  //=========================================================================
  /**
  * Standard Konstruktor
  * 
  * @param int $id
  * @param string[] $data
  */

  public function __construct($id = -1, $data = null) {
    $this->_tableName = 'news';
    $this->_primaryKey = 'id';
    parent::__construct($id, $data);
  } //end of __construct

  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  protected function _restoreStandardValues() {

    $this->id = -1;
    $this->newsdate = '';
    $this->heading = '';
    $this->abstract = '';
    $this->abstracthtml = '';
    $this->linkurl = '';
    $this->languagesID = -1;

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
  public function setId($value) {
    $this->id = $value;
  } //end of setId

  //=========================================================================
  /**
  * @return int
  */
  public function getLanguagesId() {
    return intval($this->languagesId);
  } //end of getLanguagesId

  //=========================================================================
  /**
  * @param int $value
  */
  public function setLanguagesId($value) {
    $this->languagesId = $value;
  } //end of setLanguagesId


  //=========================================================================
  /**
  * @return string
  */
  public function getNewsDate() {
    return ($this->newsdate);
  } //end of getNewsDate

  //=========================================================================
  /**
  * @param string $value
  */
  public function setNewsDate($value) {
    $this->newsdate = $value;
  } //end of setNewsDate

  //=========================================================================
  /**
  * @return string
  */
  public function getHeading() {
    return ($this->heading);
  } //end of getHeading

  //=========================================================================
  /**
  * @param string $value
  */
  public function setHeading($value) {
    $this->heading = $value;
  } //end of setHeading

  //=========================================================================
  /**
  * @return string
  */
  public function getAbstract() {
    return ($this->abstract);
  } //end of getAbstract

  //=========================================================================
  /**
  * @param string $value
  */
  public function setAbstract($value) {
    $this->abstract = $value;
  } //end of setAbstract

  //=========================================================================
  /**
  * @return string
  */
  public function getAbstractHtml() {
    return ($this->abstracthtml);
  } //end of getAbstractHtml

  //=========================================================================
  /**
  * @param string $value
  */
  public function setAbstractHtml($value) {
    $this->abstracthtml = $value;
  } //end of setAbstractHtml

  //=========================================================================
  /**
  * @return string
  */
  public function getLinkUrl() {
    return ($this->linkurl);
  } //end of getLinkUrl

  //=========================================================================
  /**
  * @param string $value
  */
  public function setLinkUrl($value) {
    $this->linkurl = $value;
  } //end of setLinkUrl

} //end of Lecture
?>
