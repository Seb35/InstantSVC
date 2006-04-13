#!/usr/bin/php5.1
<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Tech Test for transformat xml input with xslt		   		   **
//**                                                                       **
//** @package    proof-of-concept							   **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************


$file = $_SERVER['argv'][1];
$xslFile = $_SERVER['argv'][2];


// Load the XML source
$xml = new DOMDocument();
$xml->load($file);

$xsl = new DOMDocument();
$xsl->load($xslFile);

// Configure the transformer
$proc = new XSLTProcessor();
$proc->importStyleSheet($xsl); // attach the xsl rules
$proc->setParameter('', 'bookmarkuri', 'http://www.bookmark.uri');
echo $proc->transformToXML($xml);
?>