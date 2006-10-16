<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** AdminToolDB - Kapselt die Datenbankanfragen                           **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    admintool                                                 **
//** @author     Martin Sprengel <martin.sprengel@hpi.uni-potsdam.de>      **
//** @copyright  2006 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//** @lastchange 2005-12-12 Martin Sprengel                                **
//**             2006-03-08 Stefan Marr                                    **
//**                         - insertClass überarbeitet                    **
//**                         - setMethodsPublished hinzugefügt             **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/admin-tool-config.php');
require_once(ADODB_DIR.'/adodb.inc.php');

//***** AdminToolDB *********************************************************
/**
 * Diese Klasse stellt die Verbindung zur Datenbank her und stellt anderen
 * Klassen bestimmte Funktionen zur Verfügung.
 *
 * @package    admintool
 * @author     Martin Sprengel <martin.sprengel@hpi.uni-potsdam.de>
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class AdminToolDB {

/**
 * Serverip oder -name für die Datenbank
 * @var string
 */
private $server = 'localhost';

/**
 * Benutzername für die Datenbank
 * @var string
 */
private $user = 'root';

/**
 * Passwort für die Datenbank
 * @var string
 */
private $password = '';

/**
 * Name der Datenbank
 * @var string
 */
private $database = 'wsdl-db';
//private $database = 'teletask';
/**
 * Instanzvariable für den Zugriff auf die Datenbank
 * @var ADOConnection
 */
private $db;

/**
 * Name der Log-Datei
 * @var string
 */
private $log_file_name = 'admin-tool-log.txt';

/**
 * Instanzvariable für den Zugriff auf das Logfile
 */
private $log_file;


//===========================================================================
/**
 * Verbindungsaufbau zur Datenbank
 * @return void
 */
public function __construct() {
  $dbcfg = @include(dirname(__FILE__).'/dbconfig.php');
  if (!empty($dbcfg) and is_array($dbcfg)) {
    $this->server = $dbcfg['server'];
    $this->user = $dbcfg['user'];
    $this->password = $dbcfg['password'];
    $this->database = $dbcfg['database'];
  }
  $this->db = ADONewConnection('mysql');
  $this->db->Connect($this->server, $this->user, $this->password, $this->database);
  $this->db->SetFetchMode(ADODB_FETCH_ASSOC);
  //$this->db->debug = true;
  // Log-File oeffnen
  $this->log_file = fopen($this->log_file_name, "a+");
  // fwrite($this->log_file,"<= " . strftime("%Y-%m-%d %H:%M:%S") . " = Start ==================\r\n");

} // end of __construct


//===========================================================================
/**
 * Schließen der Datenbankverbindung
 * @return void
 */
public function __destruct() {
  $this->db->close();
  // fwrite($this->log_file,"<= " . strftime("%Y-%m-%d %H:%M:%S") . " = Ende ===================\r\n");
  fclose($this->log_file);
} // end of __destruct


//===========================================================================
/**
 * Schreibt eine Fehlermeldung in die Log-Datei
 * @param string $content - Inhalt, der in die Log-Datei geschrieben werden soll
 * @return void
 */
private function lwrite($content) {

  fwrite($this->log_file,
    "<= " . strftime("%Y-%m-%d %H:%M:%S") . " ==========================\r\n");
  fwrite($this->log_file,$content);
  fwrite($this->log_file,
    "\r\n===========================>\r\n");

} // end of logWrite


//***************************************************************************
//** Funktionen für Klassen                                                **
//***************************************************************************


//===========================================================================
/**
 * Fügt der Datenbank eine Klasse hinzu
 * @param string $className - Name der Klasse, zu der die Methode gehört
 * @param string $path - Pfad zur Datei der Klasse
 * @return int - ID der Klasse, -1 bei Fehler
 */
public function insertClass($className) {

  // SQL-Anfragestring: Steht Klassenname schon in der DB?
  $query = "SELECT class_table_id " .
           "FROM class_table " .
           "WHERE class_name = '" . $className . "'";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  } // end if

  // Steht die Klasse noch nicht in der DB ...
  if ($rset->RecordCount() == 0) {
    // SQL-Anfragestring: Klasse eintragen
    $query = "INSERT INTO class_table (class_table_id, class_name, class_file, description) " .
             "VALUES ('',".$this->db->qstr($className).",".$this->db->qstr($path).", NULL)";
    $rset = $this->db->Execute($query);

    // War das Insert nicht erfolgreich ...
    if (!$rset) {
      $this->lwrite($this->db->ErrorMsg().' SQL: '.$query);
      return -1;
    } // Ende von if
    return $this->db->Insert_ID('class_table');
  }
  else {
    return $rset->fields["class_table_id"];
  }
} // end of insertClass


//===========================================================================
/**
 * Gibt eine Klasse anhand seines Namens zurück
 * @param string $class_name - Name der Klasse
 * @return array - Datensatz der Klasse
 */
public function getClassByName($class_name) {

  // SQL-Anfragestring: Steht Klassenname schon in der DB?
  $query = "SELECT class_table_id, class_name " .
           "FROM class_table " .
           "WHERE class_name = '" . $class_name . "'";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  } // end if
  if ($rset->RecordCount() == 0) {
    return null;
  }
  else {
    $class["class_id"] = $rset->fields["class_table_id"];
    $class["class_name"] = $rset->fields["class_name"];
    return $class;
  }

} // end of getClassByName


//===========================================================================
/**
 * Gibt eine Klasse anhand seiner ID zurück
 * @param string $class_id - ID der Klasse
 * @return array - Datensatz der Klasse
 */
public function getClassByID($class_id) {

  // SQL-Anfragestring: Steht Klassenname schon in der DB?
  $query = "SELECT class_table_id, class_name " .
           "FROM class_table " .
           "WHERE class_table_id = '" . $class_id . "'";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  } // end if
  if ($rset->RecordCount() == 0) {
    return null;
  }
  else {
    $class["class_id"] = $rset->fields["class_table_id"];
    $class["class_name"] = $rset->fields["class_name"];
    return $class;
  }

} // end of getClassByID


//===========================================================================
/**
 * Gibt eine Liste aller registrierten Klassen zurück
 * @param void
 * @return array<string,string>[] - Array mit Datensätzen aller gespeicherten Klassen
 */
public function getClasses() {
  // SQL Statement, welches an die Datenbank geschickt wird
  $query = "SELECT * FROM class_table";
  $rset = $this->db->Execute($query);

  // Fehler beim holen der Daten?
  if (!$rset) {
    print $this->db->ErrorMsg();
  } // end if
  else {
    $classes = array();
    while (!$rset->EOF) {
      $classes[$rset->fields['class_table_id']] = $rset->fields;
      $rset->MoveNext();
    } // end while

    return $classes;
  } // end else
} // end of getClasses


//***************************************************************************
//** Funktionen für Methoden                                               **
//***************************************************************************


//===========================================================================
/**
 * Fügt die Methode einer Klasse, mit Veröffentlichungs-Status in die
 * Datenbank ein
 * @param int $class_id - ID der Klasse, zu der die Methode gehört
 * @param string $methodName - Name der Methode, die in der DB gespeichert werden soll
 * @param boolean $state - Status der Methode, true = soll veröffentlicht werden
 * @return int - ID der Methode, -1 bei Fehler
 */
public function insertMethod($class_id, $methodName, $state = 1) {

  // SQL-Anfragestring: Steht die Methode schon in der DB
  $query = "SELECT method_table_id " .
           "FROM method_table " .
           "WHERE method_name = '" . $methodName . "' AND " .
                  "class_table_id = '" . $class_id . "'";
  $rset = $this->db->Execute($query);
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  } // end if
  // Steht die Methode noch nicht in der DB ...
  if ($rset->RecordCount() == 0) {
    // SQL-Anfragestring: Methode eintragen
    $query = "INSERT INTO method_table
                 (method_table_id, method_name, class_table_id, publish, description) " .
             "VALUES
                 ('','" . $methodName . "','" . $class_id . "','" . $state . "',NULL)";
    $rset = $this->db->Execute($query);
    // War das Insert nicht erfolgreich ...
    if (!$rset) {
      $this->lwrite($this->db->ErrorMsg());
    } // end if
    return $this->db->Insert_ID('method_table');
  } // end if
  else {
    return $rset->fields["method_table_id"];
  }
} // end of insertMethod


//===========================================================================
/**
 * Gibt den Publikationsstatus einer Methode zurück
 * @param string $className - Name der Klasse, zu der die Methode gehört
 * @param string $methodName - Name der Methode, zu der der Status abgefragt werden soll
 * @return boolean - true, wenn Methode veröffentlicht werden soll, sonst false
 */
public function getMethodState($className, $methodName) {
  // SQL-Anfragestring: Steht die Methode schon in der DB
  $query = "SELECT m.publish " .
           "FROM method_table m, class_table c " .
           "WHERE m.method_name = '" . $methodName . "' AND " .
                 "c.class_name = '" . $className . "' AND " .
                 "c.class_table_id = m.class_table_id";
  $rset = $this->db->Execute($query);
  if (!$rset) {
    echo $this->db->ErrorMsg();
  } // end if
  else {
    if ($rset->RecordCount() == 0) {
      /*
      die("PF-PlugIn: Status der Methode kann nicht zurückgegeben werden, da " .
          "die Methode nicht in der DB steht.<br>\n");
      */
    }
    else {
      return $rset->fields["publish"];
    }
  }
} // end of getMethodState


//===========================================================================
/**
 * Gibt eine Liste Methoden einer Klasse zurück
 * @param integer $class_id - Primary Key der Klasse, zu der Methoden gesucht werden sollen
 * @return array<string,string>[] - Array mit Datensätzen aller Methoden, der
 *         angegebenen Klasse
 */
public function getMethodsByClass($class_id) {
  // SQL Statement, welches an die Datenbank geschickt wird
  $query = "SELECT method_table_id, method_name, publish, description " .
           "FROM method_table " .
           "WHERE class_table_id = '" . $class_id . "'";
  $rset = $this->db->Execute($query);

  // Fehler beim holen der Daten?
  if (!$rset) {
    print $this->db->ErrorMsg();
  } // end if
  else {
    $methods = array();
    while (!$rset->EOF) {
      $methods[$rset->fields['method_table_id']] = $rset->fields;
      $rset->MoveNext();
    } // end while

    return $methods;
  } // end else
} // end of getClasses


//===========================================================================
/**
 * Gibt die Methode einer Klasse anhand ihres Namens zurück
 * @param int $class_id - ID der Klasse
 * @param string $method_name - Name der Methode
 * @return array - Datensatz der Klasse
 */
public function getMethodByName($class_id, $method_name) {

  // Methode nach Namen abfragen
  $query = "SELECT method_table_id, method_name " .
           "FROM method_table " .
           "WHERE class_table_id = '" . $class_id . "' AND " .
                 "method_name = '" . $method_name . "'";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  } // end if
  if ($rset->RecordCount() == 0) {
    return null;
  }
  else {
    $method["method_id"] = $rset->fields["method_table_id"];
    $method["method_name"] = $rset->fields["method_name"];
    return $method;
  }

} //end of  getClassByName


//===========================================================================
/**
 * Gibt die Methode einer Klasse anhand ihrer ID zurück
 * @param string $method_id- ID der Methode
 * @return array - Datensatz der Klasse
 */
public function getMethodByID($method_id) {

  // Methode nach Namen abfragen
  $query = "SELECT method_table_id, method_name, publish, class_table_id " .
           "FROM method_table " .
           "WHERE method_table_id = '" . $method_id . "'";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  } // end if
  if ($rset->RecordCount() == 0) {
    return null;
  }
  else {
    $method["method_id"] = $rset->fields["method_table_id"];
    $method["method_name"] = $rset->fields["method_name"];
    $method["method_publish"] = $rset->fields["publish"];
    $method["method_class_id"] = $rset->fields["class_table_id"];
    return $method;
  }

} //end of getClassByName


//===========================================================================
/**
 * Setzt den Status einer Methode auf den mit published übergebenen Wert
 * @param int $method_id - ID der Methode
 * @param boolean - Veroeffentlichungsstatus der Methdode
 * @return boolean - true, bei erfolgreicher Abarbeitung, sonst false
 */
public function setMethodPublished($method_id, $published = 1) {

  $query = "UPDATE method_table SET publish = '" . $published . "' " .
           "WHERE method_table_id = '" . $method_id . "'";
  $rset = $this->db->Execute($query);
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return false;
  } else {
    return true;
  }
}
    //=======================================================================
    /**
     * @param integer $classId
     * @param integer[] $methodIds
     */
    public function setMethodsPublished($classId, array $methodIds) {
        $sql = 'UPDATE method_table SET publish=0 WHERE class_table_id='.
                $this->db->qstr($classId);
        $r = $this->db->Execute($sql);
        if (!$r) {
            $this->lwrite($this->db->ErrorMsg());
        }

        if (is_array($methodIds) and count($methodIds) > 0) {
            $sql = 'UPDATE method_table SET publish=1 WHERE 0 ';
            foreach ($methodIds as $id) {
            	$sql .= ' OR method_table_id='.$this->db->qstr($id);
            }
            $r = $this->db->Execute($sql);
            if (!$r) {
                $this->lwrite($this->db->ErrorMsg());
            }
        }
    }

//***************************************************************************
//** Funktionen für Kommentare                                             **
//***************************************************************************


//===========================================================================
/**
 * Speichert das Kommentar einer Methode in der Datenbank. Der Benutzer hat die Möglichkeit
 * eigene Kommentare zu speichern. Zunächst wird dazu das Source-Code Kommentar in
 * einer extra Spalte gespeichert.
 * Des Weiteren wird ein flag in der Datenbank gesetzt, wenn ein alter Source-Code
 * Kommentar überschrieben wurde. Neuer Kommentar.
 * @param int $method_id - ID der Methode
 * @param string $comment
 * @return int - ID des SourceCode-Kommentars, -1 bei Fehler
 */
public function insertSourceCodeComment($method_id, $comment) {

  $query = "SELECT c.comment, c.comment_table_id " .
           "FROM method_table m, comment_table c " .
           "WHERE m.method_table_id = '" . $method_id . "' AND " .
                 "m.source_comment = c.comment_table_id";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  }

  // noch kein Kommentar in der Datenbank ...
  if ($rset->RecordCount() == 0) {

    // Neues Kommentar anlegen
    $query = "INSERT INTO comment_table " .
                "(comment_table_id, comment, description) " .
             "VALUES " .
                "('','" . $comment . "','NULL')";
    $rset = $this->db->Execute($query);
    if (!$rset) {
      $this->lwrite($this->db->ErrorMsg());
      return -1;
    }

    $comment_table_id = $this->db->Insert_ID();

    // Kommentar an Methode binden
    $query = "UPDATE method_table m SET m.source_comment = '" .
               $comment_table_id . "' " .
             "WHERE m.method_table_id = '" . $method_id . "'";
    $rset = $this->db->Execute($query);
    if (!$rset) {
      $this->lwrite($this->db->ErrorMsg());
      return -1;
    }

  }
  // Wenn schon ein Kommentar in der Datenbank steht, updaten
  else {

    // Veraendertes Kommentar im Source-Code
    if ($rset->fields["comment"] != $comment) {

      $query = "UPDATE comment_table c SET c.comment = '" . $comment . "' " .
               "WHERE c.comment_table_id = '" . $rset->fields["comment_table_id"] . "'";
      $rset = $this->db->Execute($query);
      if (!$rset) {
         $this->lwrite($this->db->ErrorMsg());
         return -1;
      }

      // Veränderung des Source-Code Kommentars festhalten
      $query = "UPDATE method_table m SET m.source_comment_changed = '1' " .
               "WHERE m.method_table_id = '" . $method_id . "'";
      $rset = $this->db->Execute($query);
      if (!$rset) {
         $this->lwrite($this->db->ErrorMsg());
         return -1;
      }
    }
  }

} // end of insertSourceCodeComment


//===========================================================================
/**
 * Fügt ein Benuter-Kommentar in die Datenbank ein
 * @param int $method_id - ID der Methode, zu der der Kommentar eingefügt werden soll
 * @param string $comment - einzufuegender Kommentar
 * @return void
 */
public function insertUserComment($method_id, $comment) {

  $query = "SELECT c.comment, c.comment_table_id " .
           "FROM method_table m, comment_table c " .
           "WHERE m.method_table_id = '" . $method_id . "' AND " .
                 "m.user_comment = c.comment_table_id";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  }

  // Noch kein Benutzer-Kommentar in der Datenbank vorhanden
  if ($rset->RecordCount() == 0) {

    $query = "INSERT INTO comment_table " .
               "(comment_table_id, comment, description) " .
             "VALUES " .
               "('','". $comment . "','NULL')";
               $rset = $this->db->Execute($query);
    // Ist ein Fehler aufgetreten ...
    if (!$rset) {
      $this->lwrite($this->db->ErrorMsg());
      return -1;
    }

    $comment_table_id = $this->db->Insert_ID();

    $query = "UPDATE method_table m SET m.user_comment = '" . $comment_table_id . "' "  .
             "WHERE m.method_table_id = '" . $method_id . "'";
    $rset = $this->db->Execute($query);
    // Ist ein Fehler aufgetreten ...
    if (!$rset) {
      $this->lwrite($this->db->ErrorMsg());
      return -1;
    }

  }
  // es existiert schon ein Benutzer Kommentar
  else {

    $query = "UPDATE comment_table c SET c.comment = '" . $comment . "' " .
             "WHERE c.comment_table_id = '" . $rset->fields["comment_table_id"] . "'";
    $rset = $this->db->Execute($query);
    // Ist ein Fehler aufgetreten ...
    if (!$rset) {
      $this->lwrite($this->db->ErrorMsg());
      return -1;
    }

  }

}  //end of  insertUserComment

    //=======================================================================
    /**
     * @param string $class
     * @param string $method
     * @return string
     */
    public function getUserComment($class, $method) {
        $sql = 'SELECT c.comment, c.comment_table_id FROM comment_table c '.
               'JOIN method_table m ON (m.user_comment = c.comment_table_id) '.
               'JOIN class_table cl ON (m.class_table_id = cl.class_table_id) '.
               'WHERE cl.class_name = '.$this->db->qstr($class).' AND '.
                     'm.method_name = '.$this->db->qstr($method);

        $rset = $this->db->Execute($sql);
        // Ist ein Fehler aufgetreten ...
        if (!$rset) {
            $this->lwrite($this->db->ErrorMsg());
            return -1;
        }

        if ($rset->RecordCount() != 0) {
            $comment["comment_id"] = $rset->fields["comment_table_id"];
            $comment["comment"] = $rset->fields["comment"];
            return $comment;
        }
        else {
            return null;
        }
    }


//===========================================================================
/**
 * Gibt den Kommentar eines Benutzers zurück
 * @param int $method_id - ID der Methode
 * @return array<string,string>
 */
public function getUserCommentByMethod($method_id) {

  $query = "SELECT c.comment, c.comment_table_id, c.description " .
           "FROM method_table m, comment_table c " .
           "WHERE m.method_table_id = '" . $method_id . "' AND " .
                 "m.user_comment = c.comment_table_id";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  }


  if ($rset->RecordCount() != 0) {

    $comment["comment_id"] = $rset->fields["comment_table_id"];
    $comment["comment"] = $rset->fields["comment"];
    return $comment;
  }
  else {
    return null;
  }
}  //end of  getUserCommentByMethod


//===========================================================================
/**
 * Gibt den Source-Code Kommentar
 * @param int $method_id - ID der Methode
 * @return array<string,string>
 */
public function getSourceCodeCommentByMethod($method_id) {

  $query = "SELECT c.comment, c.comment_table_id, c.description " .
           "FROM method_table m, comment_table c " .
           "WHERE m.method_table_id = '" . $method_id . "' AND " .
                 "m.source_comment = c.comment_table_id";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  }

  if ($rset->RecordCount() != 0) {

    $comment["comment_id"] = $rset->fields["comment_table_id"];
    $comment["comment"] = $rset->fields["comment"];
    return $comment;

  } else {
    return null;
  }

} //end of getSourceCodeCommentByMethod


//===========================================================================
/**
 * Gibt den Source-Code Kommentar
 * @param int $method_id - ID der Methode
 * @return array<string,string>
 */
public function setSourceCodeCommentChanged($method_id, $changed = 0) {

  $query = "UPDATE method_table m SET m.source_comment_changed = '" . $changed . "' " .
           "WHERE m.method_table_id = '" . $method_id . "'";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  }


} // Ende von setSourceCodeCommentChanged


//===========================================================================
/**
 * Setzt den security-flag einer Klasse
 * @param int $class_id - ID der Methode
 * @return int
 */
public function setSecurity($class_id, $security_flag = 1) {

  $query = "UPDATE class_table c SET c.use_wss = '" . $security_flag . "' " .
           "WHERE c.class_table_id = '" . $class_id . "'";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  } else {
    return 1;
  }
} //end of setSecurity

//===========================================================================
/**
 * Fragt den security-flag einer Klasse ab
 * @param int $class_id - ID der Methode
 * @return int
 */
public function isSecurity($class_id) {

  $query = "SELECT c.use_wss FROM class_table c " .
           "WHERE c.class_table_id = '" . $class_id . "'";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
    return -1;
  } else {
    return $rset->fields["use_wss"];
  }
} // end of  isSecurity


//***************************************************************************
//** Funktionen für den Wizard des Admin-Tools                             **
//***************************************************************************


//===========================================================================
/**
 * Gibt eine Eigenschaft des Admin-Tools zurück
 * @param string $property
 * @return string - den Wert der Eigenschaft oder null wenn
 *                  diese noch nicht vorhanden war
 */
public function getProperty($property) {

  $query = "SELECT value FROM tool_properties " .
           "WHERE property = '" . $property . "'";
  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
  } else {
    if ($rset->RecordCount() == 0) {
      return null;
    } else {
      return $rset->fields["value"];
    }
  }

} //end of getProperty


//===========================================================================
/**
 * Setzt eine Eigenschaft in der DB
 * @param string $property
 * @param string $value
 * @return void
 */
public function setProperty($property, $value) {

  if (is_null($this->getProperty($property))) {

    $query = "INSERT INTO tool_properties " .
               "(id, property, value, description) " .
             "VALUES " .
               "('', '" . $property . "','" . $value . "', NULL)";

  } else {

    $query = "UPDATE tool_properties SET value = '" . $value ."' " .
             "WHERE property = '" . $property . "'";

  }

  $rset = $this->db->Execute($query);
  // Ist ein Fehler aufgetreten ...
  if (!$rset) {
    $this->lwrite($this->db->ErrorMsg());
  }
} //end of setProperty

} // end of Database


?>