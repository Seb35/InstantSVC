<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Modul - wickelt den Steuerungs- und Eingabeverarbeitungsteil ab                          **
//**                                                                       **
//** project: Web Services Description Generator                    **
//**                                                                       **
//** @package    example.teletask
//** @copyright  2006 Andreas Meyer, Sebastian Böttner
//** @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
//** @author Andreas Meyer, Sebastian Böttner                 **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** Modul ************************************************************
/**
//**wickelt den Steuerungs- und Eingabeverarbeitungsteil ab
//** @package    example.teletask
//** @copyright  2006 Andreas Meyer, Sebastian Böttner
//** @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
//** @author Andreas Meyer, Sebastian Böttner
 */
class Lectures {

  //=========================================================================
  static public function execute() {
    $lectures = dbLectures::getInstance();
    $tpldata['lectures'] = $lectures->getItems();

    if (isset($_REQUEST['lecture_id'])) {
      $tpldata['lecture'] = new dbLecture($_REQUEST['lecture_id']);
      $streams = dbStreams::getInstance();
      $tpldata['lecture']->streams = $streams->getStreamsForLecture($_REQUEST['lecture_id']);
    }

    //Generierung der URL für das Smile-File mit allen gewählten Eigenschaften
    if (isset($_REQUEST['action']) and $_REQUEST['action'] == 'view') {
      $player = 'index.php?action=smile';

      if (isset($_REQUEST['streams'])) {
        foreach ($_REQUEST['streams'] as $stream_id) {
          $player .= '&amp;streams[]='.$stream_id;
        }

        if (isset($_REQUEST['start'])) {
          $player .= '&amp;start='.$_REQUEST['start'];
        }
        if (isset($_REQUEST['end'])) {
          $player .= '&amp;end='.$_REQUEST['end'];
        }
        $tpldata['player'] = $player;
      }
    }



    if (isset($_REQUEST['action']) and $_REQUEST['action'] == 'smile') {
      if (isset($_REQUEST['streams'])) {
        foreach ($_REQUEST['streams'] as $stream_id) {
          $tpldata['streams'][] = new dbStream($stream_id);
        }
      }

      if (isset($_REQUEST['start']) and strlen(trim($_REQUEST['start']))>0) {
        $tpldata['start'] = $_REQUEST['start'];
      }

      if (isset($_REQUEST['end']) and strlen(trim($_REQUEST['end']))>0) {
        $tpldata['end'] = $_REQUEST['end'];
      }

      $render = new wsRenderEngine($tpldata);
      $render->setTemplate('smil.tpl.xml');
      header('Content-Type: application/smil');
    }
    else {
      $render = new wsRenderEngine($tpldata);
      $render->setTemplate('index.tpl.xhtml');
    }
    $render->display();
  }
}
?>