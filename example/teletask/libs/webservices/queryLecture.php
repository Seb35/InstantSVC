<?php

require_once(dirname(__FILE__).'/../queryLecture.php');

//***** queryLecture ********************************************************
/**
* queryLecture - provides basic queries on table lectures of the Teletask DB
*
* @author Andreas Meyer
* @author Sebastian Böttner
* @package    example.teletask
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
* last change: 2006-02-27 Andreas Meyer

 * Merken für erstellen eines generators:
 *  - prüfen ob singleton interface implemenitert wurde, um auch von singletons
 *    services machen zu können
 *
*/

class queryLectureSoapAdapter {

    private $target;

    public function __construct() {
        $this->target = queryLecture::getInstance();
    }

    /**
    * @return Lecture[]
    */
    public function getAllLectures() {

        //$r = $this->target->getAllLectures();
        $r[] = new Lecture();
        $r[] = new Lecture();
        $r[] = new Lecture();
        return array("GetAllLecturesResult" => $r);
  }

  /**
   * @param int $param
   * @return Lecture
   */
  public function getLecture($param) {
      return array("Lecture" => new Lecture());
      //return array("Lecture" => $this->target->getLecture($param->id));
  }

  /*
  * @param string $param
  * @return Lecture[]
  */
  public function getLecturesBySeries($param) {
      $r = $this->target->getLecturesBySeries($param->seriesName);
      return array("GetLecturesBySeriesResult" => $r);
  }
} //end of queryLectureSoapAdapter

?>
