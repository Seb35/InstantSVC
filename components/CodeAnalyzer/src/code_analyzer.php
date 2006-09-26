<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** iscCodeAnalyzer - searchs through source tree and collects infos      **
//**                   about found classes and files                       **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    CodeAnalyzer                                              **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 InstantSVC Team                                      **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** iscCodeAnalyzer *****************************************************
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
* @package    CodeAnalyzer
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 InstantSVC Team
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class iscCodeAnalyzer {

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var array<string,mixed>
	 */
	protected $statsArray;

	/**
	 * @var array<string,iscCodeAnalyzerFileDetails>
	 */
	protected $flatStatsArray;

	/**
	 * @var array<string,mixed>
	 */
	protected $docuFlaws;

    //=======================================================================
    /**
    * @param string $path
    */
    public function __construct($path = '.') {
        $this->path = $path;
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
    * @return array<string,mixed>
    */
    public function getStats() {
        return $this->flatStatsArray;
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
        $this->inspectFiles(null);
    }

    //=======================================================================
    /**
     * Parse the given directory recursivly
     *
     * @param string $path
     * @param array $statsArray
     */
    protected function parseDir($path, &$statsArray) {
    	if (is_dir($path)) {
    	    if ($dir = opendir($path)) {
                while (($file = readdir($dir)) !== false) {
                    if ($file != '..' && $file != '.' &&
                        $file != '.svn' && $file != 'CVS') {
                        if (is_dir($path.'/'.$file)) {
                            $statsArray[$file] = array();
                            $this->parseDir($path.'/'.$file,$statsArray[$file]);
                        }
                        else {
                            $statsArray[$file] = new iscCodeAnalyzerFileDetails
                                                        ($path.'/'.$file);
                        }
                    }
                }
                closedir($dir);
    	    }
    	}
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
        $dirDetails = new iscCodeAnalyzerFileDetails($basekey);
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
     *
     * @param string[] $files array of filenames
     */
    public function inspectFiles($files) {
        $this->docuFlaws = array();
        $this->docuFlaws['classes'] = array();
        $this->docuFlaws['functions'] = array();
        $this->docuFlaws['interfaces'] = array();

        if ($files == null) {
            $files = $this->flatStatsArray;
        }

        foreach ($files as $file) {
            $filename = null;
            if (is_string($file)) {
                $filename = $file;
            }
            //TODO: may be it's better to use a php -l check here like in the class loader
            elseif ($file->mimeType == 'application/x-httpd-php') {
                $filename = $file->fileName;
            }

            if (!empty($filename)) {

                $filename = strtr($filename, DIRECTORY_SEPARATOR, '/');
                $result = self::summarizeInSandbox($filename);

                if (is_array($result)) {
                    $this->docuFlaws['classes'] = array_merge_recursive($this->docuFlaws['classes'],
                                                          $result['classes']);
                    $this->docuFlaws['functions'] = array_merge_recursive($this->docuFlaws['functions'],
                                                          $result['functions']);
                    $this->docuFlaws['interfaces'] = array_merge_recursive($this->docuFlaws['interfaces'],
                                                          $result['interfaces']);
                }
            }
        }
    }

    /**
     * Calls summarizeFile in a new php process.
     * @param string[] $classes array with classnames
     * @return array(string => array)
     */
    public static function summarizeInSandbox($filename) {
        $return = null;
        $pipeDesc = array(
           0 => array('pipe', 'r'),  //in, child reads from
           1 => array('pipe', 'w'),  //out, child writes to
           2 => array('pipe', 'w')   //err, child writes to
        );

        $process = proc_open('php', $pipeDesc, $pipes);

        if (is_resource($process)) {
            $phpCommands = '<?php
                @include_once \'ezc/Base/base.php\';
                @include_once \'Base/base.php\';
                function __autoload( $className ) { ezcBase::autoload( $className ); }
                require_once "'.__FILE__.'";

                ob_start();
                $out = serialize(iscCodeAnalyzer::summarizeFile(\''.addslashes($filename).'\'));
                ob_end_clean();
                echo \'#-#-#-#-#\';
                echo $out;
                echo \'#-#-#-#-#\';
            ?>';

            //pipe commands to new process and close pipe to start processing by php
            fwrite($pipes[0], $phpCommands);
            fclose($pipes[0]);

            //get result and close return and error pipe
            $result = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            // pipes are closed to avoid a deadlock
            proc_close($process);

            $arr = split('#-#-#-#-#', $result);
            if (isset($arr[1])) {
                $old = error_reporting(0);
                $return = unserialize($arr[1]);
                error_reporting($old);
            }
        }

        return $return;
    }

    /**
     * Collect summary for given file
     *
     * @param string $filename
     * @return array(string => array)
     */
    public static function summarizeFile($filename) {
        ob_start();
        require_once $filename;
        ob_end_clean();

        $classes = array();
        $decClasses = get_declared_classes();
        foreach ($decClasses as $class) {
            $class = new ReflectionClass($class);
            if ($class->getFileName() == realpath($filename)) {
                $classes[] = $class->getName();
            }
        }
        $classes = self::summarizeClasses($classes);

        $inters = array();
        $interfaces = get_declared_interfaces();
        foreach ($interfaces as $inter) {
            $inter = new ReflectionClass($inter);
            if ($inter->getFileName() == realpath($filename)) {
                $inters[] = $inter->getName();
            }
        }
        $inters = self::summarizeInterfaces($inters);

        $functs = array();
        $functions = get_defined_functions();
        foreach ($functions['user'] as $func) {
            $func = new ReflectionFunction($func);
            if ($func->getFileName() == realpath($filename)) {
        	   $functs[] = $func->getName();
            }
        }
        $functs = self::summarizeFunctions($functs);

        return array('classes' => $classes, 'interfaces' => $inters,
                     'functions' => $functs);
    }

    //=======================================================================
    /**
     * Will build summary of all code constructs and their meta data
     *
     * Is called by inc.iscCodeAnalyzer.php and returns an array structur
     * serialized by serialize() as string
     *
     * @param $classes
     * @return string
     */
    public static function summarizeClasses($classes) {
        $result = array();
        foreach ($classes as $className) {
            $class = new iscReflectionClass($className);

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

            $result[$className]['isInternal'] = $class->isInternal();
            $result[$className]['isAbstract'] = $class->isAbstract();
            $result[$className]['isFinal'] = $class->isFinal();
            $result[$className]['isInterface'] = $class->isInterface();
            if ($class->getParentClass() != null) {
                $result[$className]['parentClass'] =
                                          $class->getParentClass()->getName();
            }
            else {
                $result[$className]['parentClass'] = null;
            }
            $result[$className]['modifiers'] = $class->getModifiers();

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
                $result[$className]['methods'][$method->getName()]['isInternal']
                            = $method->isInternal();
                $result[$className]['methods'][$method->getName()]['isAbstract']
                            = $method->isAbstract();
                $result[$className]['methods'][$method->getName()]['isFinal']
                            = $method->isFinal();
                $result[$className]['methods'][$method->getName()]['isPublic']
                            = $method->isPublic();
                $result[$className]['methods'][$method->getName()]['isPrivate']
                            = $method->isPrivate();
                $result[$className]['methods'][$method->getName()]['isProtected']
                            = $method->isProtected();
                $result[$className]['methods'][$method->getName()]['isStatic']
                            = $method->isStatic();
                $result[$className]['methods'][$method->getName()]['modifiers']
                            = $method->getModifiers();

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
        return $result;
    }

    public static function summarizeInterfaces($interfaces) {
        //throw new Exception('Not Implemented, but should be similar to summarizeClasses');
        return array();
    }


    public static function summarizeFunctions($functions) {
        $functs = array();
        foreach ($functions as $funcName) {
        	$func = new iscReflectionFunction($funcName);
        	$functs[$funcName]['comment'] = (strlen($func->getDocComment()) > 10);
            $functs[$funcName]['file'] = $func->getFileName();

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

        return $functs;
    }
}

?>