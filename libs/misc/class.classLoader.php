<?php

require_once(dirname(__FILE__).'/class.mimetypes.php');

class ClassLoader {
    /**
     * @var Mime_Types
     */
    private static $mimeHandler;
    private static $instance = null;
    /**
     * @var boolean
     */
    private static $debug = false;

    private function __construct() {

    }

    //=======================================================================
    /**
     * Load php-files in the given directory recursivly
     * @param string $path
     */
    public static function loadDir($path) {
      if (self::$debug) echo 'loaddir: '.$path."\n";
      if (is_dir($path)) {
        if ($dir = opendir($path)) {
          while (($file = readdir($dir)) !== false) {
            if ($file != '..' && $file != '.' && $file != '.svn' && $file != 'CVS') {
              if (is_dir($path.'/'.$file)) {
                self::loadDir($path.'/'.$file);
              }
              else {
                self::loadClass($path.'/'.$file);
              }
            }
          }
          closedir($dir);
        }
      }
    }


    //=======================================================================
    /**
     * Includes a file if it seams to be a php file
     * @param string $file
     */
    public static function loadClass($file) {
        if ($file != '' and file_exists($file)) {
            $mimeType = self::guessMimeType($file);

            if ($mimeType == 'application/x-httpd-php') {
              try {
                if (self::$debug) echo 'load:    '.$file."\n";
                ob_start();
                include_once($file);
                ob_end_clean();
              }
              catch(Exception $e) {

              }
            }
        }
    }

    //===========================================================================
    /**
     * @param string $file
     */
    protected static function guessMimeType($file) {
        if (self::$mimeHandler == null) {
            self::$mimeHandler = new Mime_Types('mime.types');
        }
        $parts = explode('.', $file);
        return self::$mimeHandler->get_type($parts[count($parts)-1]);
    }

    //===========================================================================
    /**
     * @param boolean $val
     */
    public static function setDebug($val) {
        self::$debug = $val;
    }

}

?>
