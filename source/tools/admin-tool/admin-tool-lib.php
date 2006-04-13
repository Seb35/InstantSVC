<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** AdminTool - Library                                                   **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    admintool                                                 **
//** @author     Martin Sprengel <martin.sprengel@hpi.uni-potsdam.de>      **
//** @copyright  2006 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//** @lastchange 2005-11-26 Martin Sprengel                                **
//**             2006-03-08 Stefan Marr                                    **
//**                         - Umstellung von ClassLoader auf CodeAnalyzer **
//**                         - Methoden zum ansprechen der Generatoren     **
//**                                                                       **
//***************************************************************************
//***************************************************************************
error_reporting(E_ALL);

//***** imports *************************************************************
require_once dirname(__FILE__).'/../../../libs/misc/class.codeAnalyzer.php';
require_once dirname(__FILE__).'/admin-tool-db.php';
require_once(dirname(__FILE__).'/../../libs/Generators/class.WSDLGenerator.php');
require_once(dirname(__FILE__).'/../../libs/Generators/class.soapDdGenerator.php');
require_once(dirname(__FILE__).'/../../libs/Generators/class.DocumentWrappedAdapterGenerator.php');

//***** AdminToolLibrary ****************************************************
/**
 * Diese Klasse grundlegende Funktionen zur Verfügung
 *
 * @package    admintool
 * @author     Martin Sprengel <martin.sprengel@hpi.uni-potsdam.de>
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class AdminToolLibrary {


/** Variable für Datenbankzugriff */
  /**
   * @var AdminToolDB
   */
  private $db = null;

//===========================================================================
/**
 * Initialisierung
 * @return void
 */
public function __construct() {

  // Variablen initialisieren
  $this->db      = new AdminToolDB();

}


//===========================================================================
/**
 * Speichert Methoden einer Klasse
 * @param int $class_id
 * @param string[] $method_list
 * @return void
 */
public function saveMethods($class_id, $method_list = array()) {

  // Alle Methoden der Klasse abfragen
  $methods = $this->db->getMethodsByClass($class_id);
  foreach ($methods as $key => $method) {
    if (in_array($key, $method_list)) {
      $this->db->setMethodPublished($key,true);
    } else {
      $this->db->setMethodPublished($key,false);
    }
  }

} // end of saveMethods


//=======================================================================
/**
 * Parst einen Pfad und gibt alle Klassen des Pfades zurück.
 *
 * @param string $path
 * @return string[]
 */
public function getAllClasses($path) {
  $path = realpath($path);
  if ($path !== false) {
      $analyzer = new CodeAnalyzer($path);
      $analyzer->setPhpBinPath(PHP_BIN_PATH);
      $analyzer->collect();
      $analyzer->inspectFiles();
      $summary = $analyzer->getCodeSummary();

      $classes = array();
      foreach ($summary['classes'] as $name => $class) {
        //nur wenn die klasse wirklich in dem pfad liegt
      	if (strpos($class['file'], $path) !== false) {
      	  $classes[$name] = $class;
      	}
      }
      return $classes;
  }
  return null;
}


//=======================================================================
/**
 * Parst einen Pfad und gibt alle Klassen des Pfades zurück.
 *
 * @param string[] $classes
 * @return string[]
 */
public function filterWebServiceClasses($classes) {
  $class_list = array();
  $index = 1;
  foreach ($classes as $key => $value) {

    $class = new ExtReflectionClass($value);
    if ($class->isWebService()) {
      $class_list[$index] = $value;
      $index++;
    }

  }
  return $class_list;

}


//=======================================================================
/**
 * Gibt alle Klassen mit einem at-WebService Tag. Gesucht wird
 * im übergebenen Pfad
 *
 * @param string $path
 * @return string[]
 */
public function getWebServiceClasses($path) {

  $this->loadDir($path);
  $declared_class_list = get_declared_classes();
  $class_list = array();

  $index = 1;
  foreach ($declared_class_list as $key => $value) {

    $class = new ExtReflectionClass($value);
    if ($class->isWebService()) {
      $class_list[$index] = $value;
      $index++;
    }

  }
  return $class_list;
}


//===========================================================================
/**
 * Speichert Benutzer-Kommentar in der Datenbank
 * @param int $method_id
 * @param string $user_comment
 * @return void
 */
public function saveUserComment($method_id, $user_comment) {

  // Alle Methoden der Klasse abfragen
  $this->db->insertUserComment($method_id, $user_comment);

} // end of saveUserComment


//===========================================================================
/**
 * Gibt eine Liste aller registrierten Klassen zurück
 * @return mixed
 */
public function getRegisteredClasses() {

  // Alle registrierten Klassen abfragen
  return $this->db->getClasses();

} // Ende von getRegisteredClasses

    //=======================================================================
    /**
     * @param String $className
     * @param String $classFile
     * @param String $serviceName
     * @param String $serviceUri
     * @param String $namespace
     * @param Integer $binding
     * @param String $wsdlfile
     * @return boolean
     */
    public static function generateWsdl($className, $classFile, $serviceName, $serviceUri, $namespace, $binding, $wsdlfile) {
        if (!class_exists($className)) {
            require_once($classFile);
        }
        $generator = new WSDLGenerator($serviceName, $serviceUri, $namespace, $binding);
        $generator->setClass($className, true);
        return $generator->saveToFile($wsdlfile);
    }

    //=======================================================================
    /**
     * @param String $targetPath
     * @param array<string,string>[] $ddInfos
     */
    public static function generateDd($targetPath, array $ddInfos) {
        $generator = new SoapDeploymentDescriptorGenerator();

        foreach ($ddInfos as $ser) {
            $generator->addService($ser['wsdlfile'], $ser['servicename'],
                                   $ser['classfile'], $ser['classname'],
                                   $ser['utp']);
        }
        $generator->setDeployPath($targetPath);
        $generator->save();
    }

    //=======================================================================
    /**
     * @param string $targetPath
     * @return boolean
     */
    public static function generateServer($targetPath) {
        return copy(dirname(__FILE__).'/../../libs/Server/soap.php', $targetPath.'/soap.php');
    }

    //=======================================================================
    /**
     * @param string $className
     * @param string $targetPath
     * @return string path of generated file
     */
    public static function generateAdapter($className, $targetPath) {
        $generator = new DocumentWrappedAdapterGenerator($className);
        return $generator->saveToFile($targetPath);
    }

    //=======================================================================
    /**
     * @param string $className
     * @return string
     */
    public static function getAdapterClassName($className) {
        return DocumentWrappedAdapterGenerator::generateAdapterClassName($className);
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
        $publishedMethods = array();

        foreach($methods as $method) {
            try {
                $method_name = $method->getName();
                $class_name = $method->getDeclaringClass()->getName();
                $class_file = $method->getDeclaringClass()->getFileName();
                $comment = $method->getDocComment();
            }
            catch (Exception $e) {
                die($e->getMessage());
            }

            $class_id = $this->db->insertClass($class_name, $class_file);
            $method_id = $this->db->insertMethod($class_id, $method_name);
            $this->db->insertSourceCodeComment($method_id, $comment);
            $publish_state = $this->db->getMethodState($class_name, $method_name);

            if ($publish_state) {
                $publishedMethods[] = $method;
            }

        } // end foreach

        return $publishedMethods;

    } // end getPublishedMethods
}

?>