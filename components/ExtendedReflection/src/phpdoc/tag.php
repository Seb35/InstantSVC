<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** PHPDocTag - Provides structured data from PHP Documentation comments  **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    reflection                                                **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2005 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/tags/require.tags.php');

//***** PHPDocTag ***********************************************************
/**
* Provides structured data from PHP Documentation comments
*
* @package    libs.reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 Stefan Marr
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class PHPDocTag {
    /**
    * @var string
    */
    protected $tagName;

    /**
    * @var string[]
    */
    protected $params;

    /**
    * @var string
    */
    protected $desc;


    //=======================================================================
    /**
    * @param string[] $line Array of words
    */
    public function __construct($line) {
        $this->tagName = $line[0];

        if (count($line) == 4) {
            $this->params[] = $line[1];
            $this->params[] = $line[2];
            $this->desc = $line[3];
        }
        elseif (count($line) == 3) {
            $this->params[] = $line[1];
            $this->desc = $line[2];
        }
        elseif (count($line) == 2) {
            $this->params[] = $line[1];
        }
    }

    //=======================================================================
    /**
    * @return string
    */
    public function getDescription() {
        return $this->desc;
    }

    //=======================================================================
    /**
    * @param string $line
    */
    public function addDescriptionLine($line) {
        $this->desc .= "\n".$line;
    }

    //=======================================================================
    /**
    * @return string
    */
    public function getTagName() {
        return $this->tagName;
    }
}
?>
