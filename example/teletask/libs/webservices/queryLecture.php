<?php

require_once(dirname(__FILE__).'/../queryLecture.php');
/**
 * Merken für erstellen eines generators:
 *  - prüfen ob singleton interface implemenitert wurde, um auch von singletons
 *    services machen zu können
 *
 * @package    example.teletask
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
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
   * @param int $id
   * @return Lecture
   */
  public function getLecture($param) {
      return array("Lecture" => new Lecture());
      //return array("Lecture" => $this->target->getLecture($param->id));
  }

  /*
  * @param string $seriesName
  * @return Lecture[]
  */
  public function getLecturesBySeries($param) {
      $r = $this->target->getLecturesBySeries($param->seriesName);
      return array("GetLecturesBySeriesResult" => $r);
  }
} //end of wsDBCollection

?>
