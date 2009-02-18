<?php

//***************************************************************************
//***************************************************************************
//**                                                                       **
//** fileDetails									         **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    libs.misc                                                 **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** FileDetails *********************************************************
/**
 *
 * @package    libs.misc
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 ....
 * @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
 */
class FileDetails {

    /**
     * @var string
     */
    public $mimeType;

    /**
     * @var int
     */
    public $linesOfCode = 0;

    /**
     * @var int
     */
    public $fileSize = 0;

    /**
     * @var string
     */
    public $fileName = '';

    /**
     * @var MimeHandler
     */
    private static $mimeHandler = null;

    /**
     * @var string
     */
    private static $locMimes = null; 

    //=======================================================================
    /**
     * @param string $file
     */
    
    public function __construct($file = '') {
        $this->fileName = realpath($file);
        if ($file != '' and file_exists($file)) {
            $this->mimeType = $this->guessMimeType($file);

            if ($this->shouldCountLines($this->mimeType)) {
                $this->linesOfCode = count(file($file));
            }
            else {
                $this->linesOfCode = null;
            }
            $this->fileSize = filesize($file);

            //if ($this->mimeType == 'application/x-httpd-php') {
            //    include_once($file);
            //}
        }
    }

    //=======================================================================
    /**
     * @webmethod
     * @param string $file
     * @return boolean
     */
    protected function guessMimeType($file) {
        if (self::$mimeHandler == null) {
            require_once('class.mimetypes.php');
            self::$mimeHandler = new Mime_Types(dirname(__FILE__).'/mime.types');
        }
        $parts = explode('.', $file);
        return self::$mimeHandler->get_type($parts[count($parts)-1]);
    }

    protected function shouldCountLines($mime) {
        if (self::$locMimes == null) {
            self::$locMimes[] = 'application/x-httpd-php';
            self::$locMimes[] = 'application/x-javascript';
        }

        if (in_array($mime, self::$locMimes) or strpos($mime, 'text') !== false) {
            return true;
        }
        return false;
    }
}
?>
