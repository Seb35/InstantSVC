<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** XmlSoapHeaderParser - parse a soap message and delete the header      **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package Username Token                                               **
//** @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>    **
//** @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>      **
//** @copyright 2006 2006 Christoph Hartmann, Michael Perscheid            **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2005-12-18 - Implement the class                          **
//**                                                                       **
//***************************************************************************
//***************************************************************************

// include base parser
require_once(dirname(__FILE__).'/XmlParserExtended.php');
// include check algorithm
require_once(dirname(__FILE__).'/../UserTokenProfile/ICheckUserRunnable.php');

//***** XmlSoapHeaderParser *************************************************
/**
* Delete the complete Soapheader
*
* @package libs.soap
* @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author  Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright 2006 Christoph Hartmann, Michael Perscheid 
* @license http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class XmlSoapHeaderParser extends XmlParserExtended {

  /**
  * @var boolean
  */
  // save the tagstate
  private $isHeaderTag       = FALSE;

  //=======================================================================
  /**
   * Constructor
   *
   * Set default options for the xml_soap_header_parser
   */
  public function __construct() {
    parent::__construct();
  } // end of __construct

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

    if ($tagName == "Header") {
      $this->isHeaderTag = TRUE;
      // save the delete element
      $this->deleteTag = $tag;
    } // end if
  } // end of start_tag

  //=======================================================================
  /**
   * close tag recognizer
   *
   * will be executed at an closing tag
   *
   * @param resource $parser
   * @param string  $tag
   */
  private function close_tag($parser, $tag)
  {
    list($nameSpace,$tagName) = $this->sepNameSpaceAndTag($tag);

    // security exsist
    if ($tagName == "Header") {
      $this->isHeaderTag = FALSE;
    } // end if
  } // end of close_tag

  //=======================================================================
  /**
   * data within a tag recognizer
   *
   * will be executed when data between opening and closed tag is found
   *
   * @param resource $parser
   * @param string  $data
   */
  private function characters($parser, $cdata)
  {
     // nothing to do here
  } // end of characters
} // end of class XmlSoapHeaderParser
?>