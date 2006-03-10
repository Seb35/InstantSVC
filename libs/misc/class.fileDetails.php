<?php
class FileDetails {
    public $mimeType;
    public $linesOfCode = 0;
    public $fileSize = 0;
    public $fileName = '';

    private static $mimeHandler = null;
    private static $locMimes = null;

    public function __construct($file = '') {
        $this->fileName = realpath($file);
        if ($file != '' and file_exists($file)) {
            if (function_exists('mime_content_type')) {
                $this->mimeType = mime_content_type($file);
            }
            else {
                $this->mimeType = $this->guessMimeType($file);
            }

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

    /**
     * @webmethod
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