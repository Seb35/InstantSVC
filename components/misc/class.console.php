<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** Console  - provides an interface to stdin and stdout for console apps **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    libs.misc                                                 **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once('Console/Getopt.php');

//***** Bookmark ************************************************************
/**
 * Console provides an interface to stdin, stdout and stderr by using
 * common methods.
 *
 * @package    libs.misc
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class Console {

    /**
     * @var resource
     */
    private $in = STDIN;

    /**
     * @var resource
     */
    private $out = STDOUT;

    /**
     * @var resource
     */
    private $err = STDERR;

    //=========================================================================
    public function __construct() {
    }

    //=========================================================================
    /**
     * Returns arguments using PEAR's GetOpt
     * @see   Console_Getopt
     * @param string $short Short options string for getopt
     * @param string[] $long Long otptions arrray for getopt
     * @return mixed[]
     */
    public function getArgs($short, $long = null) {
        $args = Console_Getopt::readPHPArgv();
        array_shift($args);
        return Console_Getopt::getopt2($args, $short, $long);
    }

    //=========================================================================
    /**
     * Write string to output stream
     * @param string $str
     */
    public function write($str) {
        fwrite($this->out, $str);
    }

    //=========================================================================
    /**
     * Write string to output stream and add a newline
     * @param string $str
     */
    public function writeLn($str = '') {
        fwrite($this->out, $str."\n");
    }

    //=========================================================================
    /**
     * Reads a whole line
     * @return string
     */
    public function readLn() {
        return trim(fgets($this->in));
    }

    //=========================================================================
    /**
     * Reads data in the given format from input stream
     * @param string $format
     * @return mixed
     */
    public function read($format) {
        return fscanf($this->in, $format);
    }

    //=========================================================================
    /**
     * Writes a string to stderr
     * @param string $str
     */
    public function writeError($str) {
        fwrite($this->err, $str);
    }

    //=========================================================================
    /**
     * Writes a string and a newline to stderr
     * @param string $str
     */
    public function writeErrorLn($str) {
        fwrite($this->err, $str."\n");
    }
}

?>