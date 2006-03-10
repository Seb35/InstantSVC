<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** XmlSoapSecParser - This class realise a general Soap-Security-Parser  **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package Username Token                                               **
//** @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>    **
//** @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>      **
//** @copyright 2006 ....                                                  **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2005-12-18 - Implement the class                          **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
// include base parser
require_once('XmlParserExtended.php');
// include check algorithm
require_once('ICheckUserRunnable.php');


//***** XmlSoapSecParser ****************************************************
/**
* This class realise a general Soap-Security-Parser
*
* Parse a xml soap message and search and validate the given username
* and password. This class implements the wsse standard
* UserName Token Profile 1.0.
*
* This class require a ICheckUserRunnable to validate authentication data,
* which implements the main algorithm for the standard.
* This parser only search for the required data.
*
* @package libs.soap.wsse
* @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright 2006 ....
* @license http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class XmlSoapSecParser extends XmlParserExtended {

  // save the tagstate
  /**
  * @var boolean
  */
  private $isSecurityTag      = FALSE;
  /**
  * @var boolean
  */
  private $isUsernameTokenTag = FALSE;
  /**
  * @var boolean
  */
  private $isUserameTag       = FALSE;
  /**
  * @var boolean
  */
  private $isPasswordTag      = FALSE;
  /**
  * @var boolean
  */
  private $isNonceTag         = FALSE;
  /**
  * @var boolean
  */
  private $isCreatedTag       = FALSE;

  // data from the header
  /**
  * @var string
  */
  private $username = "";
  /**
  * @var string
  */
  private $password = "";
  /**
  * @var string
  */
  private $nonce    = "";
  /**
  * @var string
  */
  private $created  = "";

  // Exmplar zum checken, ob user registriert
  /**
  * @var unknown
  */
  private $checkUserRunnable = null;

  //=======================================================================
  /**
   * Constructor
   *
   * Set default options for the xml_soap_header_parser
   */
  public function __constuct() {
    parent::xml_parser();
  } // end of __construct

  //=======================================================================
  /**
   * overwrite the parse method,
   *
   * to control the user and delete the SecurityTag
   * true - user is available else false
   */
  public function parse($data) {
    // parse the document
    parent::parse($data);

    if (isset($this->checkUserRunnable)) {
      try {
        return  $this->checkUserRunnable->run(
                                $this->username,
                                $this->password,
                                $this->nonce,
                                $this->created);
      } // end try
      catch (Exception $e) {
        return FALSE;
      } // end catch
    } // end if
	else {
      return FALSE;
    } // end else
  } // end of parse

  //=======================================================================
  /**
    * addCheckUserRunnable
    *
    * add an instance to check the user
    */
  public function addCheckUserRunnable($runnable) {
    $this->checkUserRunnable = $runnable;
  } // end of addCheckUserRunnable

  //=======================================================================
  /**
  * open tag recognizer
  *
  * will be executed at an opening tag
  *
  * @param unknown $parser
  * @param string  $tag
  * @param string  $attributes
  */
  private function start_tag($parser, $tag, $attributes)
  {
    list($nameSpace,$tagName) = $this->sepNameSpaceAndTag($tag);

    if ($tagName == "Security") {
      $this->isSecurityTag = TRUE;
      $this->deleteTag = $tag;
    } // end if
	else if ($tagName == "UsernameToken") {
      $this->isUsernameTokenTag = TRUE;
    } // end else if
	else if ($tagName == "Username") {
      $this->isUserameTag = TRUE;
    } // end else if
	else if ($tagName == "Password") {
      $this->isPasswordTag = TRUE;
    } // end else if
	else if ($tagName == "Nonce") {
      $this->isNonceTag = TRUE;
    } // end else if
	else if ($tagName == "Created") {
      $this->isCreatedTag = TRUE;
    } // end else if
    else {
    } // end else
  } // end of start_tag

  //=======================================================================
  /**
   * close tag recognizer
   *
   * will be executed at an closing tag
   *
   * @param unknown $parser
   * @param string  $tag
   */
  private function close_tag($parser, $tag)
  {
    list($nameSpace,$tagName) = $this->sepNameSpaceAndTag($tag);

    if ($tagName == "Security") {
      $this->isSecurityTag = FALSE;
    } // end if
	else if ($tagName == "UsernameToken") {
      $this->isUsernameTokenTag = FALSE;
    } // end else if
	else if ($tagName == "Username") {
      $this->isUserameTag = FALSE;
    } // end else if
	else if ($tagName == "Password") {
      $this->isPasswordTag = FALSE;
    } // end else if
	else if ($tagName == "Nonce") {
      $this->isNonceTag = FALSE;
    } // end else if
	else if ($tagName == "Created") {
      $this->isCreatedTag = FALSE;
    } // end else if
    else {
    } // end else
  } // end of close_tag

  //=======================================================================
  /**
   * data within a tag recognizer
   *
   * will be executed when data between opening and closed tag is found
   *
   * @param unknown $parser
   * @param string  $data
   */
  private function characters($parser, $cdata)
  {
    if ( ($this->isSecurityTag == TRUE) &&
         ($this->isUsernameTokenTag == TRUE) )
    {
      if ( ($this->isUserameTag == TRUE) ) {
        $this->username = $cdata;
      } // end if
      if ( ($this->isPasswordTag == TRUE) ) {
        $this->password = $cdata;
      } // end if
      if ( ($this->isNonceTag == TRUE) ) {
        $this->nonce = $cdata;
      } // end if
      if ( ($this->isCreatedTag == TRUE) ) {
        $this->created = $cdata;
      } // end if
    } // end if
  } // end of characters
} // end of class XmlSoapSecParser
?>
