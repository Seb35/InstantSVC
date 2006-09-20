<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** iscReflectionDocParser - Returns infos from a given PHP Documentation comment   **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    reflection                                                **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @author     Falko Menge <mail@falko-menge.de>                         **
//** @copyright  2005-2006 ...                                             **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
//require_once(dirname(__FILE__).'/class.iscReflectionDocTagFactory.php');

//***** Parser Constants ****************************************************
define('BEGINNING',  10);
define('SHORT_DESC', 0);
define('LONG_DESC',  1);
define('TAGS',       2);

//***** iscReflectionDocParser ********************************************************
/**
* Provides structured data from PHP Documentation comments
*
* @package    Reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @author     Falko Menge <mail@falko-menge.de>
* @copyright  2006 ...
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class iscReflectionDocParser {
    /**
    * @var string
    */
    protected $docComment;

    /**
    * @var int STATE
    */
    protected $state = BEGINNING;

    /**
    * @var array<int,int>
    */
    protected $stateTable = array(BEGINNING  => SHORT_DESC,
                                   SHORT_DESC => SHORT_DESC,
                                   LONG_DESC  => LONG_DESC,
                                   TAGS       => TAGS);
    /**
    * @var iscReflectionDocTag
    */
    protected $lastTag = null;

    /**
    * @var string
    */
    protected $shortDesc;

    /**
    * @var string
    */
    protected $longDesc;

    /**
    * @var iscReflectionDocTag[]
    */
    protected $tags;

    //=======================================================================
    /**
    * @param string $docComment
    */
    public function __construct($docComment) {
        $this->docComment = $docComment;
        $this->tags = array();
    }

    //=======================================================================
    public function parse() {
        $lines = explode("\n", $this->docComment);

        foreach ($lines as $line) {
            $line = trim($line);
            $line = $this->stripDocPrefix($line);

            if (strlen($line) > 0) {
                //special condition for state change
                if ($line{0} == '@' or $this->state == TAGS) {
                    $this->parseTag($line);
                }
                else {
                    if ($this->state == SHORT_DESC
                                      OR $this->state == BEGINNING) {
                        $this->shortDesc .= $line . "\n";
                    }
                    elseif ($this->state == LONG_DESC) {
                        $this->longDesc .= $line . "\n";
                    }
                }
                //next state
                $this->state = $this->stateTable[$this->state];
            }
            else {
                //Change to next state if nessesary
                switch ($this->state) {
                    case BEGINNING:
                        //NOP
                        break;
                    case LONG_DESC:
                        $this->longDesc .= "\n";
                        break;
                    case SHORT_DESC:
                        $this->state = LONG_DESC;
                        break;
                    default:
                        $this->state = $this->stateTable[$this->state];
                        break;
                }
            }
        }
        $this->shortDesc = trim($this->shortDesc);
        $this->longDesc = trim($this->longDesc);
    }

    //=======================================================================
    /**
    * @param string $line
    * @return string
    */
    protected function stripDocPrefix($line) {
        while (strlen($line) > 0 and ($line{0} == '/' or $line{0} == '*')) {
            $line = substr($line, 1);
        }

        return trim($line);
    }

    //=======================================================================
    /**
    * @param string $line
    * @return void
    */
    protected function parseTag($line) {
        if (strlen($line) > 0) {
            if ($line{0} == '@') {
                $line = substr($line, 1);
                $words = explode(' ', $line, 4);
                $tag = iscReflectionDocTagFactory::createTag($words[0], $words);
                $this->tags[$tag->getName()][] = $tag;
                $this->lastTag = $tag;
            }
            else {
                //no leading @, it is assumed a description is multiline
                if ($this->lastTag != null) {
                    $this->lastTag->addDescriptionLine($line);
                }
            }
        }
    }

    //=======================================================================
    /**
    * @param string $name
    * @return iscReflectionDocTag[]
    */
    public function getTagsByName($name) {
        if (isset($this->tags[$name])) {
            return $this->tags[$name];
        }
        else {
            return array();
        }
    }

    //=======================================================================
    /**
    * @return iscReflectionDocTag[]
    */
    public function getTags() {
        $result = array();
        foreach ($this->tags as $tags) {
            foreach ($tags as $tag) {
                $result[] = $tag;
            }
        }
        return $result;
    }

    //=======================================================================
    /**
    * @return iscReflectionDocTagParam[]
    */
    public function getParamTags() {
        return $this->getTagsByName('param');
    }

    //=======================================================================
    /**
    * @return iscReflectionDocTagVar[]
    */
    public function getVarTags() {
        return $this->getTagsByName('var');
    }

    //=======================================================================
    /**
    * @return iscReflectionDocTagReturn[]
    */
    public function getReturnTags() {
        return $this->getTagsByName('return');
    }

    //=======================================================================
    /**
    * To check whether a tag was used
    * @param string $with name of used tag
    * @return boolean
    */
    public function isTagged($with) {
        return isset($this->tags[$with]);
    }

    //=======================================================================
    /**
    * @return string
    */
    public function getShortDescription() {
        return $this->shortDesc;
    }

    //=======================================================================
    /**
    * @return string
    */
    public function getLongDescription() {
        return $this->longDesc;
    }
}
?>
