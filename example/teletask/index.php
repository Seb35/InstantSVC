<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** index.php - Einstiegspunkt für alle Anfragen                          **
//**                                                                       **
//** Projekt: Übung 1, Projektarbeit Web-Programmierung                    **
//**                                                                       **
//** 2005 by Andreas Meyer, Sebastian Böttner, Stefan Marr                 **
//**                                                                       **
//** last change: 2005-10-27 Stefan Marr                                   **
//**                                                                       **
//***************************************************************************
//***************************************************************************

/**
 * @package    example.teletask
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */


//***** imports *************************************************************
require_once('boot.php');
require_once('constants.php');
require_once(TTEX_LIBS.'queryLecture.php');

$zeugs = queryLecture::getInstance();

/*
* executes getIdAndNameOfAllLectures(), should return an array of strings,
* the index reflects the id of an entry, the value its name
*/
//$bar['1'] = 'Turing Maschinen';
//$bar['2'] = 'Probleme und Algorithmen';
//$bar['3'] = 'Erreichbarkeitsmethode';
//$foo = $zeugs->getIdAndNameOfAllLectures();

/*
* executes getAllLectures(), should return an array of Lectures
*/
//$foo = $zeugs->getAllLectures() ;

/*
* executes updateOrAddLectures(dbLecture $lecture), should update entry 15,
* and insert a new lecture with a copy of entry 10
*/
//$lecture = new Lecture(31, null);
//$lecture->setID(1000);
//$zeugs->updateOrAddLecture($lecture);
//$lecture->setID(-1);
//$zeugs->updateOrAddLecture($lecture);

/*
* executes getLectureNamebyID($id), should return a string
*/
//$foo = $zeugs->getLectureNamebyID(27) ;


/*
* executes getLectureNamebyID($id),alters the name of lecture 18 to "jürgen"
*/
//$zeugs->updateLectureNamebyID(18, 'jürgen');

/*
* executes getLecturesByLecturegroups($lecturegroupName)
* returns an array of Lectures
*/
//$foo = $zeugs->getLecturesByLecturegroups('Web-Programmierung');

//var_dump($foo);

?>
