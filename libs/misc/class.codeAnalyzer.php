<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** CodeAnalyzer - searchs through source tree and collects infos about   **
//**                found classes and files                                **
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

//***** imports *************************************************************
require_once(dirname(__FILE__).'/class.fileDetails.php');
require_once(dirname(__FILE__).'/../config/config.php');
require_once(dirname(__FILE__).'/../../source/libs/reflection/class.ExtReflectionClass.php');
require_once(dirname(__FILE__).'/../../source/libs/reflection/class.ExtReflectionFunction.php');
require_once(dirname(__FILE__).'/../genesis-core/class.renderEngine.php');

//***** CodeAnalyzer ********************************************************
/**
* searchs through source tree and collects infos about found classes
* and files
*
* Some basic statistics are collected:
*   - LoC
*   - count of elements (classes, methods, ...)
*   - Missing DocTags per element
*   - used DocTags
*
* @package    libs.misc
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class CodeAnalyzer {

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var String[]
	 */
	protected $declaredClasses;

	/**
	 * @var array<string,mixed>
	 */
	protected $statsArray;

	/**
	 * @var array<string,FileDetails>
	 */
	protected $flatStatsArray;

	/**
	 * @var array<string,mixed>
	 */
	protected $docuFlaws;

	/**
	 * @var string
	 */
	protected $phpBin;

    //=======================================================================
    /**
    * @param string $path
    */
    public function __construct($path) {
        $this->path = $path;
        $this->declaredClasses = get_declared_classes();
    }

    //=======================================================================
    /**
    * @param String[] $declaredClasses
    */
    public function setDeclaredClasses($declaredClasses) {
        $this->declaredClasses = $declaredClasses;
    }

    //=======================================================================
    /**
    * @return array<string,mixed>
    */
    public function getCodeSummary() {
        return $this->docuFlaws;
    }

    //=======================================================================
    /**
    * Starts collection of stats
    * Traverses the directory tree and collects statistical data
    * Doesn't include any file in current php process
    */
    public function collect() {
        $this->parseDir($this->path, $this->statsArray);
        $this->flatStatsArray = $this->flatoutStatsArray($this->statsArray, '');
    }

    //=======================================================================
    /**
     * Parse the given directory recursivly
     *
     * @param string $path
     */
    protected function parseDir($path, &$statsArray) {
    	if (is_dir($path)) {
    	    if ($dir = opendir($path)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file != '..' && $file != '.' && $file != '.svn' && $file != 'CVS') {
                        if (is_dir($path.'/'.$file)) {
                            $statsArray[$file] = array();
                            $this->parseDir($path.'/'.$file,$statsArray[$file]);
                        }
                        else {
                            $statsArray[$file] =
                                        $this->getStatsForFile($path.'/'.$file);
                        }
                    }
                }
                closedir($dir);
    	    }
    	}
    }

    //=======================================================================
    /**
     * Enter description here...
     *
     * @param string $file
     * @return StatisticDetails
     */
    public function getStatsForFile($file) {
        return new FileDetails($file);
    }

    //=======================================================================
    /**
     * Convert statsArray to a flat one dimensional array
     * @param array<string,mixed> $array
     * @param string $basekey
     * @return array<string,mixed>
     */
    protected function flatoutStatsArray($array, $basekey) {
        $result = array();
        $dirDetails = new FileDetails($basekey);
        $dirDetails->mimeType = 'folder';
        $result[$basekey] = $dirDetails;
        foreach ($array as $key => $value) {
        	if (is_array($value)) {
        	    $r = $this->flatoutStatsArray($value, $key);
        	    $first = true;
        	    foreach ($r as $k => $v) {
        	        if ($first) {
        	            $first = false;
        	            $dirDetails->fileSize += $v->fileSize;
        	            $dirDetails->linesOfCode += $v->linesOfCode;
        	        }
                    $result[$basekey.'\\'.$k] = $v;
        	    }
        	}
        	else {
        	    $result[$basekey.'\\'.$key] = $value;
        	    $dirDetails->fileSize += $value->fileSize;
        	    $dirDetails->linesOfCode += $value->linesOfCode;
        	}
        }
        return $result;
    }

    //=======================================================================
    /**
     * Collects informations about classes, functions by spawning a new
     * php process for each file
     */
    public function inspectFiles() {

        //commandline interface or apache?
        $cli = true; (strpos(php_sapi_name(), 'cli') !== false);

        $this->docuFlaws = array();
        $this->docuFlaws['classes'] = array();
        $this->docuFlaws['functions'] = array();
        foreach ($this->flatStatsArray as $detail) {
            //var_dump($detail);
            if ($detail->mimeType == 'application/x-httpd-php') {
                $detail->fileName = strtr($detail->fileName, DIRECTORY_SEPARATOR, '/');



                $cmd = $this->phpBin.' "'.dirname(__FILE__).'/inc.codeAnalyzer.php" exec "'.$detail->fileName.'"';
                if ($cli) {
                    $out = shell_exec($cmd);
                }
                else {
                    ob_start();
                    virtual('inc.docuFlaws.php?exec=true&filename='.urlencode($detail->fileName));
                    $out = ob_get_clean();
                }
                $arr = split('#-#-#-#-#', $out);


                if (isset($arr[1])) {
                    //var_dump($arr[1]);
                    $result = unserialize($arr[1]);
                    $this->docuFlaws['classes'] = array_merge($this->docuFlaws['classes'], $result['classes']);
                    $this->docuFlaws['functions'] = array_merge($this->docuFlaws['functions'], $result['functions']);
                }
                else {
                    //var_dump( $out);die();
                }

                if (strlen(trim($arr[0])) > 1) {
                    $this->docuFlaws['messages'][$detail->fileName] = trim($arr[0]);
                }
            }
        }
    }

    //=======================================================================
    /**
     * Will build summary of all code constructs and their meta data
     *
     * Is called by inc.codeAnalyzer.php and returns an array structur
     * serialized by serialize() as string
     *
     * @param $classes
     * @return string
     */
    public static function collectCodeSummary($classes) {
        $result = array();
        foreach ($classes as $className) {
            $class = new ExtReflectionClass($className);

            //Collect Class-Tags
            $tags = $class->getTags();
            foreach ($tags as $tag) {
            	$result[$className]['tags'][] = $tag->getTagName();
            }

            //Collect special class info
            $result[$className]['file'] = $class->getFileName();
            $result[$className]['classComment'] =
                                        (strlen($class->getDocComment()) > 10);
            $result[$className]['webservice'] = $class->isWebService();

            //Collect Class properties
            $props = $class->getProperties();
            $result[$className]['properties'] = array();
            foreach ($props as $property) {
                if (is_object($property->getType())) {
            	   $result[$className]['properties'][$property->getName()]
            	            = $property->getType()->toString();
                }
                else {
                    $result[$className]['properties'][$property->getName()]
            	            = null;
                }
            }

            //Collect class methods
            $methods = $class->getMethods();
            $missingMethodComments = 0;
            $missingParamTypes = 0;
            $result[$className]['methods'] = array();
            foreach ($methods as $method) {
                //Collect method tags
                $tags = $method->getTags();
                foreach ($tags as $tag) {
                	$result[$className]['methods'][$method->getName()]['tags'][]
                	                        = $tag->getTagName();
                }

                //Collect more infos about this method
            	$result[$className]['methods'][$method->getName()]['comment']
            	            = (strlen($method->getDocComment()) > 10);
            	if (strlen($method->getDocComment()) > 10) {
            	   $missingMethodComments++;
            	}
            	if (is_object($method->getReturnType())) {
            	   $result[$className]['methods'][$method->getName()]['return']
            	            = $method->getReturnType()->toString();
            	}
            	else {
            	    $result[$className]['methods'][$method->getName()]['return']
            	            = null;
            	}
            	$result[$className]['methods'][$method->getName()]['webmethod']
            	            = $method->isWebmethod();
            	$result[$className]['methods'][$method->getName()]['restmethod']
            	            = $method->isTagged('restmethod');

            	//Collect paramter infos
            	$params = $method->getParameters();
            	$paramFlaws = 0;
            	$result[$className]['methods'][$method->getName()]['params'] = array();
            	foreach ($params as $param) {
            	    if (is_object($param->getType())) {
                        $result[$className]['methods'][$method->getName()]
                                                ['params'][$param->getName()]
            	                                   = $param->getType()->toString();
            	    }
            	    else {
            	        $result[$className]['methods'][$method->getName()]
                                           ['params'][$param->getName()] = null;
            	    }

            	    if ($param->getType() == null) {
            	        $paramFlaws++;
            	        $missingParamTypes++;
            	    }
            	}
            	$result[$className]['methods'][$method->getName()]['paramflaws']
            	            = $paramFlaws;
            }
            $result[$className]['missingMethodComments'] = $missingMethodComments;
            $result[$className]['missingParamTypes'] = $missingParamTypes;
        }

        //Collect function infos
        $functions = get_defined_functions();
        $functs = array();
        foreach ($functions['user'] as $funcName) {
        	$func = new ExtReflectionFunction($funcName);
        	$functs[$funcName]['comment'] = (strlen($func->getDocComment()) > 10);

        	if (is_object($func->getReturnType())) {
        	    $functs[$funcName]['return'] = $func->getReturnType()->toString();
        	}
        	else {
        	    $functs[$funcName]['return'] = null;
        	}

        	$tags = $func->getTags();
        	foreach ($tags as $tag) {
        	    if (is_object($tag)) {
            	   $functs[$funcName]['tags'][] = $tag->getTagName();
        	    }
            }

        	//Collect paramter infos
        	$params = $func->getParameters();
        	$paramFlaws = 0;
        	$functs[$funcName]['params'] = array();
        	foreach ($params as $param) {
        	    if (is_object($param->getType())) {
                    $functs[$funcName]['params'][$param->getName()]
        	                                   = $param->getType()->toString();
        	    }
        	    else {
        	        $functs[$funcName]['params'][$param->getName()] = null;
        	    }

        	    if ($param->getType() == null) {
        	        $paramFlaws++;
        	    }
        	}
        	$functs[$funcName]['paramflaws'] = $paramFlaws;
        }


        return array('classes' => $result, 'functions' => $functs);
    }

    //=======================================================================
    /**
     * @param string $file
     */
    public function save($file) {
        $data['stats'] = $this->flatStatsArray;
        $data['docu'] = $this->docuFlaws;
        $render = new RenderEngine($data);
        $render->setTemplate('stats.html');
        $result = $render->fetch();

        $cli = (strpos(php_sapi_name(), 'cli') !== false);
        if ($cli) {
            $fh = fopen($file, 'w');
            fwrite($fh, $result);
            fclose($fh);
        } else {
            echo $result;
        }
    }


    public function setPhpBinPath($path) {
        $this->phpBin = $path;
    }

}

?>