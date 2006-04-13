<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Lecture - represents lecture information as php object                          **
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

//***** Lecture *************************************************************
/**
//**represents lecture information as php object
//** @package    example.teletask
//** @copyright  2006 Andreas Meyer, Sebastian Böttner
//** @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
//** @author Andreas Meyer, Sebastian Böttner
 */
class Lecture extends Item {

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
    protected $duration;
    /**
     * @var string
     */
    protected $namehtml;
    /**
     * @var string
     */
    protected $streamurldsl;
    /**
     * @var string
     */
    protected $streamurlisdn;
    /**
     * @var string
     */
    protected $streamurllivestream;
    /**
     * @var string
     */
    protected $abstract;
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
    protected $livestreamstarttime;
    /**
     * @var string
     */
    protected $livestreamendtime;
    /**
     * @var string
     */
    protected $place;
    /**
     * @var int
     */
    protected $institution;



  //=========================================================================
  /**
  * setzt alle Eigenschaften auf ihren Standardwert
  */

  public function __construct($id = -1, $data = null) {
      $this->setPrimaryKey('id');
      $this->setTableName('lectures');

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
    $this->streamurldsl = '';
    $this->streamurlisdn = '';
    $this->streamurllivestream = '';
    $this->languagesId = -1;
    $this->duration = '';
    $this->logo = -1;
    $this->time = '';
    $this->sortdate = '0000-00-00 00:00:00';
    $this->livestreamendtime = '';
    $this->livestreamstarttime = '';
    $this->place = '';
    $this->institution = -1;

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
  * @return integer
  */
  public function getDuration() {
    return $this->duration;
  } //end of getDuration

  //=========================================================================
  /**
  * @param integer $value
  */
  public function setDuration($value) {
    $this->duration = $value;
  }	//end setDuration

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
  public function getStreamUrlDsl() {
    return $this->streamurldsl;

  }	//end getStreamUrlDsl

  //=========================================================================
  /**
  * @param string $value
  */
  public function setStreamUrlDsl($value) {
    $this->streamurldsl = $value;

  }	//end setStreamUrlDsl

  //=========================================================================
  /**
  * @return string
  */
  public function getStreamUrlIsdn() {
    return $this->streamurlisdn;

  }	//end getStreamUrlIsdn

  //=========================================================================
  /**
  * @param string $value
  */
  public function setStreamUrlIsdn($value) {
    $this->streamurlisdn = $value;

  }	//end setStreamUrlIsdn

  //=========================================================================
  /**
  * @return string
  */
  public function getStreamUrlLiveStream() {
    return $this->streamurllivestream;

  }	//end getStreamUrlLiveStream

  //=========================================================================
  /**
  * @param string $value
  */
  public function setStreamUrlLiveStream($value) {
    $this->streamurllivestream = $value;

  }	//end setStreamUrlLiveStream

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
  public function getLiveStreamStartTime() {
    return $this->livestreamstarttime;

  }	//end getLiveStreamStartTime

  //=========================================================================
  /**
  * @param string $value
  */
  public function setLiveStreamStartTime($value) {
    $this->livestreamstarttime = $value;

  }	//end setLiveStreamStartTime

  //=========================================================================
  /**
  * @return string
  */
  public function getLiveStreamEndTime() {
    return $this->livestreamendtime;

  }	//end getLiveStreamEndTime

  //=========================================================================
  /**
  * @param string $value
  */
  public function setLiveStreamEndTime($value) {
    $this->livestreamendtime = $value;

  }	//end setLiveStreamEndTime

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
} //end of Lecture
?>
