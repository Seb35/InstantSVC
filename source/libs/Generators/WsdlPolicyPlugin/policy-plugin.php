<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** PolicyPlugIn - Verwaltet den Veröffentlichungsstatus von              **
//**                Methoden einer Klasse                                  **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    PolicyPlugIn                                              **
//** @author     Martin Sprengel <martin.sprengel@hpi.uni-potsdam.de>      **
//** @copyright  2006 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//** @lastchange 2005-11-26 - Martin Sprengel                              **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/../../../tools/admin-tool/admin-tool-db.php');
require_once(dirname(__FILE__).'/../../../tools/admin-tool/admin-tool-lib.php');


//***** PolicyPlugIn ********************************************************
/**
 * Dieses PlugIn kann dazu genutzt werden Methoden einer Klasse in einer
 * Datenbank zu hinterlegen. Dabei wird der Veröffentlichungsstatus dieser
 * Methoden ebenfalls gespeichert. Das heißt also, dieses PlugIn "filtert"
 * Methoden, die ein bestimmtes Flag nicht aufweisen, heraus.
 *
 * @package    PolicyPlugIn
 * @author     Martin Sprengel <martin.sprengel@hpi.uni-potsdam.de>
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class PolicyPlugIn {

    /**
     * Instanzvariable, kapselt Verbindung zur Datenbank
     * @var AdminToolDB
     */
    private $db;

    /**
     * @var AdminToolLibrary
     */
    private $lib;

//===========================================================================
/**
 *  Konstruktor - erzeugt ein neues PublishFunctions-Object und
 *                stellt über DB-Klasse Verbindung zur Datenbank her
 */
public function __construct() {
  $this->db = new AdminToolDB();
}

//===========================================================================
/**
 * Die Funktion nimmt Methoden in die DB auf und gibt alle Methoden zurück
 * die veröffentlicht werden dürfen
 * @param ReflectionMethod[] $methods - Liste mit Methoden-Objekten
 * @return ReflectionMethod[] - gefilterte Liste mit Methoden-Objekten, nur
 *         diejenigen, die veröffentlicht werden sollen
 */
public function getPublishedMethods($methods) {
  return $this->lib->getPublishedMethods($methods);
}


//===========================================================================
/**
 * Gibt ein Array mit allen Benutzer-Kommentaren zurück
 * @param ReflectionMethod[] $methods - Liste mit ReflectionMethod-Objekten
 * @return
 */
public function getUserComments($methods) {

  $comments = null;

  foreach($methods as $method) {

    try {
      $method_name = $method->getName();
      $class_name = $method->getDeclaringClass()->getName();
    }
    catch (Exception $e) {
      die($e->getMessage());
    }

    //$class = $this->db->getClassByName($class_name);
    //$method = $this->db->getMethodByName($method_name,$class["class_id"]);
    $user_comment = $this->db->getUserComment($class_name, $method_name);
    if (!is_null($user_comment)) {
      $comments[$method_name] = $user_comment["comment"];
    }
  }
var_dump($comments);
  return $comments;
}

} // Ende von PlugIn

//===========================================================================
/**
 *  DEBUG - Funktionen
 */
function constructMethods() {

  $m1["classname"] = "Testklasse1";
  $m1["methodname"] = "Testmethode1";

  $m2["classname"] = "Testklasse2";
  $m2["methodname"] = "Testmethode2";

  $methods = array($m1,$m2);
  return $methods;
}


function test() {

  echo "PlugIn gestartet ...<br>\n";
  $plugIn = new PublishFunctionsPlugIn();

  $refClass = new ReflectionClass("ReflectionClass");
  $methods  = $refClass->getMethods();

  // DEBUG-Info
  echo "DEBUG: <br/>";
  foreach($methods as $method) {
    $method_name = $method->getName();
    $class_name = $method->getDeclaringClass()->getName();
    echo "MethodenName: " . $method_name . ", Klassenname: " . $class_name . "<br/>";
  }

  $methods = $plugIn->getPublishedMethods($methods);

  // DEBUG-Info
  echo "<br>Veröffentlichte Methoden: <br/>";
  foreach($methods as $method) {
    $method_name = $method->getName();
    $class_name = $method->getDeclaringClass()->getName();
    echo "MethodenName: " . $method_name . ", Klassenname: " . $class_name . "<br/>";
  }

  $comments = $plugIn->getUserComments($methods);
  if (!is_null($comments)) {
    foreach($comments as $key => $comment) {
      echo "Methode: " . $key . "<br/> Doc: " . $comment . "<br>";
    }
  }
  /*
  echo "@return: <br>";
  foreach ($methods as $method) {
    echo "Classname: " . $method["classname"] . "<br>" .
         "Methodname: " . $method["methodname"] . "<br>";
  }
  */

  echo "PlugIn beendet.<br>\n";
}

// test();

?>
