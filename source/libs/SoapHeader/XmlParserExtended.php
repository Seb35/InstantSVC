<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** XmlParserExtended - Extend XmlParser with a delete tag method         **
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

// include base parser
require_once('XmlParser.php');

//***** XmlParserExtended****************************************************
/**
* The parser delete a part of the soapheader
*
* @package libs.xml
* @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>
* @author  Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>
* @copyright 2006 ....
* @license http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class XmlParserExtended extends XmlParser {

  /**
  * @var string
  */
  protected $deleteTag  = "";

  //=======================================================================
  /**
   * delete the part of the header which is used in the parser
   *
   * in this implementation the whole soap-header will be deleted
   *
   * @return string
   */
  public function deleteHeader() {
    return $this->deleteHeaderData($this->xmlDoc);
  } // end of deleteHeader

  //=======================================================================
  /**
   * delete the part of the header which is used in the parser
   *
   * In this implementation the whole soap-header will be deleted. It
   * takes a xml document and search for the deleteTag.
   *
   * @param string $data
   * @return string
   */
   protected function deleteHeaderData($data) {
     if ($this->deleteTag <> "") {
       // search the tag
       $firstPos  = strpos($data,$this->deleteTag);
       $secondPos = strpos($data,$this->deleteTag,$firstPos+1);

       // search tags < and >
       $firstPosWithChar =  strrpos($data,'<',-strlen($data) + $firstPos);
       $secondPosWithChar = strpos($data,'>',$secondPos);

       // calculate the length of the string
       $length = $secondPosWithChar - $firstPosWithChar ;

       // delete the data
	   $data = substr_replace($data,"",$firstPos -1 , $length +1 );
     } // end if
   return $data;
  } // end of deleteHeaderData

  //=======================================================================
  /**
   * separate namespace from tagname
   *
   * the given full qualified tagname will be splitted into two elements
   * the first will be the namespace and the second the tagname without
   * namespace
   *
   * @param string $tag
   * @return string[]
   */
  protected function sepNameSpaceAndTag($tag) {
    if (strpos($tag, ":") !== false ) {
        // namespace:tagname
        list($nameSpace, $tagName ) = split(':',$tag);
    } // end if
	else {
      // namespace nicht vorhanden
      $tagName = $tag;
      $nameSpace = "";
    } // end else

    $returnArray = array("$nameSpace","$tagName");
    return $returnArray;
  } // end of sepNameSpaceAndTag
} // end of class XmlParserExtended
?>
