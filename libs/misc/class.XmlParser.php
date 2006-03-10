<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** XmlParser - Realise a general SAX-Parser                              **
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

//***** XmlParser ***********************************************************
/**
* Realise a general SAX-Parser
*
* @package libs.xml
* @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author  Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright 2006 ....
* @license http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
abstract class XmlParser  {

  /**
   * @var resource
   */
  private $parser;

  /**
   * @var string
   */
  // speichert das XML-Dokument
  protected $xmlDoc;


  //=======================================================================
  /**
   * Constructor
   *
   * Set default options for the xml_parser
   */
  public function __construct()
  {
    // creates a new xml parser
    $this->parser = xml_parser_create();

    // connect parser with handler
    xml_set_object($this->parser, $this);

    // set case-sensitive
    xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($this->parser, XML_OPTION_SKIP_WHITE, 0);

    // set parse methods
    xml_set_element_handler($this->parser, "start_tag", "close_tag");
    xml_set_character_data_handler($this->parser, "characters");
  } // end of __constructor


  //=======================================================================
  /**
   * xml parser
   *
   * parse the given document
   *
   * @param string $data
   */
  public function parse($data)
  {
    $this->xmlDoc = $data;
    xml_parse($this->parser, $data);

    // return 0 if parse is succesful
    return 0;
  } // end of parse


  //=======================================================================
  /**
   * open tag recognizer
   *
   * will be executed at an opening tag
   *
   * @param resource $parser
   * @param string  $tag
   * @param string  $attributes
   */
  private function start_tag($parser, $tag, $attributes)
  {
    var_dump($parser, $tag, $attributes);
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
    var_dump($parser, $tag);
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
  private function characters($parser, $data)
  {
    var_dump($parser, $data);
  } // end of characters
} // end of class XmlParser
?>
