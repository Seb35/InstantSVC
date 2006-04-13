<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** TestClient - Test the SecureSoapClient                                **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package Secure Client                                                **
//** @author Christoph Hartmann <christoph.hartmann@hpi.uni-potsdam.de>    **
//** @author Michael Perscheid <michael.perscheid@hpi.uni-potsdam.de>      **
//** @copyright  2006 Christoph Hartmann, Michael Perscheid                **                                **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//** @lastchange 2006-02-04 - Test                                         **
//**                                                                       **
//***************************************************************************
//***************************************************************************

require_once('class.SecureClient.php');
// TODO namen ändern
try {
  $client = new SecureSoapClient(
            dirname(__FILE__).'/test/HalloWelt.wsdl', // WSDL description
            array('trace' => 1), // options
            "gert", // username
            "gert"); // password

  print $client->halloWelt("Hello World! From Client")."<br>";
  print "<br> Anfrage (Request):\n".highlight_string(str_replace(' xmlns:', "\n  xmlns:", str_replace('>', ">\n", $client->__getLastRequest())), true)."\n" ;
  print "<br> Antwort (Response):\n".highlight_string(str_replace(' xmlns:', "\n  xmlns:", str_replace('>', ">\n", $client->__getLastResponse())), true)."\n";

  //print $client->halloWelt("Hello World! From Client")."<br>";
//  print "<br> Anfrage (Request):\n".highlight_string(str_replace(' xmlns:', "\n  xmlns:", str_replace('>', ">\n", $client->__getLastRequest())), true)."\n" ;
//  print "<br> Antwort (Response):\n".highlight_string(str_replace(' xmlns:', "\n  xmlns:", str_replace('>', ">\n", $client->__getLastResponse())), true)."\n";

} // end try
catch(SOAPFault $f) {
  print $f->faultstring;
} // end catch

?>