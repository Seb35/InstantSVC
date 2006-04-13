<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Series - represents series information as php object                          **
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

//***** Series *************************************************************
/**
//**represents series information as php object
//** @package    example.teletask
//** @copyright  2006 Andreas Meyer, Sebastian Böttner
//** @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
//** @author Andreas Meyer, Sebastian Böttner
 */
class Series extends Item {

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
    protected $namehtml;
    /**
     * @var string
     */
    protected $abstract;
    /**
     * @var string
     */
    protected $shortabstract;
    /**
     * @var string
     */
    protected $keywords;
    /**
     * @var integer
     */
    protected $languagesId;
    /**
     * @var int
     */
    protected $logo;
    /**
     * @var string
     */
    protected $time;
    /**
     * @var string
     */
    protected $sortdate;
    /**
     * @var string
     */
    protected $place;
    /**
     * @var int
     */
    protected $institution;
    /**
     * @var string
     */
    protected $seriestype;
    /**
     * @var string
     */
    protected $template;
    /**
     * @var string
     */
    protected $externalurl;
    /**
     * @var string
     */
    protected $status;



  //=========================================================================
  /**
  * Standard Konstruktor
  * 
  * @param int $id
  * @param string[] $data
  */

  public function __construct($id = -1, $data = null) {
      $this->setPrimaryKey('id');
      $this->setTableName('series');

    parent::__construct($id, $data);
  } //end of __construct

  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  protected function _restoreStandardValues() {
    $this->id = -1;
    $this->name = '';
    $this->namehtml = '';
    $this->abstract = '';
    $this->shortabstract = '';
    $this->keywords = '';
    $this->languagesId = -1;
    $this->logo = -1;
    $this->time = '';
    $this->sortdate = '0000-00-00 00:00:00';
    $this->place = '';
    $this->institution = -1;
    $this->seriestype = 'lecture';
    $this->template = '';
	$this->externalurl = '';
	$this->abstract = '';
    $this->status = 'visible';

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
  public function getAbstract() {
    return $this->abstract;

  }	//end getAbstract

  //=========================================================================
  /**
  * @param string $value
  */
  public function setAbstract($value) {
    $this->abstract = $value;

  }	//end setAbstract

      //=========================================================================
  /**
  * @return string
  */
  public function getShortAbstract() {
    return $this->shortabstract;

  }	//end getShortAbstract

  //=========================================================================
  /**
  * @param string $value
  */
  public function setShortAbstract($value) {
    $this->shortabstract = $value;

  }	//end setShortAbstract

  //=========================================================================
  /**
  * @return string
  */
  public function getNameHtml() {
    return $this->abstract;

  }	//end getNameHtml

  //=========================================================================
  /**
  * @param string $value
  */
  public function setNameHtml($value) {
    $this->namehtml = $value;

  }	//end setNameHtml

  //=========================================================================
  /**
  * @return string
  */
  public function getKeywords() {
    return $this->keywords;

  }	//end getKeywords

  //=========================================================================
  /**
  * @param string $value
  */
  public function setKeywords($value) {
    $this->keywords = $value;

  }	//end setKeywords

  //=========================================================================
  /**
  * @return integer
  */
  public function getLanguagesId() {
    return $this->languagesId;

  }	//end getLanguagesId

  //=========================================================================
  /**
  * @param integer $value
  */
  public function setLanguagesId($value) {
    $this->languagesId = $value;

  }	//end setLanguagesId

  //=========================================================================
  /**
  * @return integer
  */
  public function getLogo() {
    return $this->logo;

  }	//end getLogo

  //=========================================================================
  /**
  * @param integer $value
  */
  public function setLogo($value) {
    $this->logo = $value;

  }	//end setLogo

  //=========================================================================
  /**
  * @return string
  */
  public function getTime() {
    return $this->time;

  }	//end getTime

  //=========================================================================
  /**
  * @param string $value
  */
  public function setTime($value) {
    $this->time = $value;

  }	//end setTime

  //=========================================================================
  /**
  * @return string
  */
  public function getSortdate() {
    return $this->sortdate;

  }	//end getSortdate

  //=========================================================================
  /**
  * @param string $value
  */
  public function setSortdate($value) {
    $this->sortdate = $value;

  }	//end setSortdate

  //=========================================================================
  /**
  * @return string
  */
  public function getPlace() {
    return $this->place;

  }	//end getPlace

  //=========================================================================
  /**
  * @param string $value
  */
  public function setPlace($value) {
    $this->place = $value;

  }	//end setPlace

  //=========================================================================
  /**
  * @return string
  */
  public function getInstitution() {
    return $this->institution;

  }	//end getInstitution

  //=========================================================================
  /**
  * @param string $value
  */
  public function setInstitution($value) {
    $this->institution = $value;

  }	//end setInstitution

  //=========================================================================
  /**
  * @return string
  */
  public function getSeriesType() {
    return $this->seriestype;

  }	//end getSeriesType

  //=========================================================================
  /**
  * @param string $value
  */
  public function setSeriesType($value) {
    $this->seriestype = $value;

  }	//end setSeriesType

  //=========================================================================
  /**
  * @return string
  */
  public function getTemplate() {
    return $this->template;

  }	//end getTemplate

  //=========================================================================
  /**
  * @param string $value
  */
  public function setTemplate($value) {
    $this->template = $value;

  }	//end setTemplate

  //=========================================================================
  /**
  * @return string
  */
  public function getExternalUrl() {
    return $this->externalurl;

  }	//end getExternalUrl

  //=========================================================================
  /**
  * @param string $value
  */
  public function setExternalUrl($value) {
    $this->externalurl = $value;

  }	//end setExternalUrl

  //=========================================================================
  /**
  * @return string
  */
  public function getStatus() {
    return $this->status;

  }	//end getStatus

  //=========================================================================
  /**
  * @param string $value
  */
  public function setStatus($value) {
    $this->status = $value;

  }	//end setStatus

} //end of Series
?>
