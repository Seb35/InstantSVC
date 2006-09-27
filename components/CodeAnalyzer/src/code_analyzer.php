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
        $process = proc_open('php -c '.escapeshellarg(dirname(__FILE__)
                            .DIRECTORY_SEPARATOR.'php.ini'), $pipeDesc, $pipes);

        if (is_resource($process)) {
            $includes = get_include_path();

            $phpCommands = '<?php
                set_include_path("'.addslashes($includes).'");
                @include_once \'ezc/Base/base.php\';
                @include_once \'Base/base.php\';
                function __autoload( $className ) { ezcBase::autoload( $className ); }
                require_once "'.addslashes(__FILE__).'";

                //ob_start();
                $out = serialize(iscCodeAnalyzer::summarizeFile(\''.addslashes($filename).'\'));
                //ob_end_clean();
                echo \'#-#-#-#-#\';
                echo $out;
                echo \'#-#-#-#-#\';
            ?>';

            //pipe commands to new process and close pipe to start processing by php
            fwrite($pipes[0], $phpCommands);
            fclose($pipes[0]);

            //get result and close return and error pipe
            $result = stream_get_contents($pipes[1]);
            $error = stream_get_contents($pipes[2]);
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
        //ob_start();
        require_once $filename;
        //ob_end_clean();
echo 'test';
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
     * Retrieves all information from the class signature
     *
     * @param iscReflectionClassType $class
     * @return array(string => mixed)
     */
    public static function summarizeClassSignature($class) {
        //Collect Class-Tags
        $tags = $class->getTags();
        foreach ($tags as $tag) {
        	$result['tags'][] = $tag->getName();
        }

        //Collect special class info
        $result['file'] = $class->getFileName();
        $result['LoDB'] = substr_count($class->getDocComment(), "\n");
        $result['isWebService'] = $class->isWebService();
        $result['isInternal'] = $class->isInternal();
        $result['isAbstract'] = $class->isAbstract();
        $result['isFinal'] = $class->isFinal();
        $result['isInterface'] = $class->isInterface();
        $result['LoC'] = $class->getEndLine() - $class->getStartLine();

        $result['interfaces'] = array();
        $interfaces = $class->getInterfaces();
        foreach ($interfaces as $inter) {
        	$result['interfaces'][] = $inter->getName();
        }

        $result['DIT'] = 1;
        if ($class->getParentClass() != null) {
            $result['parentClass'] = $class->getParentClass()->getName();

            $parent = $class->getParentClass();
            while ($parent != null) {
            	++$result['DIT'];
            	$parent = $parent->getParentClass();
            }
        }
        else {
            $result['parentClass'] = null;
        }
        $result['modifiers'] = $class->getModifiers();
        return $result;
    }

    //=======================================================================
    /**
     * Retrieve all Information about defined properties of a class
     *
     * @param iscReflectionClassType $class
     * @return array(string => mixed)
     */
    public static function summarizeClassProperties($class) {
        $props = $class->getProperties();
        $result = array();
        foreach ($props as $property) {
            if (is_object($property->getType())) {
        	   $result[$property->getName()]['type'] =
        	                                   $property->getType()->toString();
        	   $result[$property->getName()]['docuMissing'] = false;
            }
            else {
               $result[$property->getName()] = null;
               $result[$property->getName()]['docuMissing'] = true;
            }

           $result[$property->getName()]['LoDB'] =
    	                         substr_count($property->getDocComment(), "\n");

    	   $result[$property->getName()]['modifiers'] =
    	                                              $property->getModifiers();
    	   $result[$property->getName()]['isDefault'] = $property->isDefault();

    	   if ($property->isPrivate())
    	   { $result[$property->getName()]['visibility'] = 'private'; }
    	   elseif ($property->isPublic())
    	   { $result[$property->getName()]['visibility'] = 'public'; }
    	   elseif ($property->isProtected())
    	   { $result[$property->getName()]['visibility'] = 'protected'; }

    	   $result[$property->getName()]['isStatic'] = $property->isStatic();
        }
        return $result;
    }

    //=======================================================================
    /**
     * Retrieve all information about parameters of a method or a function
     *
     * @param iscReflectionFunction $method
     * @param integer $paramFlaws
     * @return array(string => mixed)
     */
    public static function summarizeFunctionParameters($method, &$paramFlaws) {
    	$params = $method->getParameters();
    	$paramFlaws = 0;
    	$result = array();
    	foreach ($params as $param) {
    	    if (is_object($param->getType())) {
                $result[$param->getName()]['type'] = $param->getType()->toString();
    	    }
    	    else {
    	        $result[$param->getName()]['type'] = null;
    	    }

    	    if ($param->getType() == null) {
    	        $paramFlaws++;
    	    }

    	    $result[$param->getName()]['isOptional'] = $param->isOptional();
    	    $result[$param->getName()]['byReference'] = $param->isPassedByReference();
    	    if ($param->isOptional()) {
        	    $result[$param->getName()]['hasDefault'] = $param->isDefaultValueAvailable();
        	    $result[$param->getName()]['defaultValue'] = $param->getDefaultValue();
    	    }
    	}
    	return $result;
    }


    //=======================================================================
    /**
     * Retrieve all information of all methods of a class
     *
     * @param iscReflectionClassType $class
     * @param integer $missingMethodComments
     * @param integer $missingParamTypes
     * @return array(string => mixed)
     */
    public static function summarizeClassMethods($class,
                                                 &$missingMethodComments,
                                                 &$missingParamTypes) {
        $methods = $class->getMethods();
        $missingMethodComments = 0;
        $missingParamTypes = 0;
        $result = array();
        foreach ($methods as $method) {
            //Collect method tags
            $tags = $method->getTags();
            foreach ($tags as $tag) {
            	$result[$method->getName()]['tags'][] = $tag->getName();
            }

            //Collect more infos about this method
            $result[$method->getName()]['isInternal'] = $method->isInternal();
            $result[$method->getName()]['isAbstract'] = $method->isAbstract();
            $result[$method->getName()]['isFinal'] = $method->isFinal();
            $result[$method->getName()]['isPublic'] = $method->isPublic();
            $result[$method->getName()]['isPrivate'] = $method->isPrivate();
            $result[$method->getName()]['isProtected'] = $method->isProtected();
            $result[$method->getName()]['isStatic'] = $method->isStatic();
            $result[$method->getName()]['modifiers'] = $method->getModifiers();
            $result[$method->getName()]['isConstructor'] = $method->isConstructor();
        	$result[$method->getName()]['isDestructor'] = $method->isDestructor();
        	$result[$method->getName()]['isOverridden'] = $method->isOverridden($class);
        	$result[$method->getName()]['isInherited'] = $method->isInherited($class);

        	if ($method->isPublic())
        	{ $result[$method->getName()]['visibility'] = 'public'; }
        	elseif ($method->isProtected())
        	{ $result[$method->getName()]['visibility'] = 'protected'; }
        	elseif ($method->isPrivate())
        	{ $result[$method->getName()]['visibility'] = 'private'; }


            $result[$method->getName()]['LoDB'] =
                                   substr_count($method->getDocComment(), "\n");
        	if ($result[$method->getName()]['LoDB'] < 1) {
        	   $missingMethodComments++;
        	}

        	if (is_object($method->getReturnType())) {
        	   $result[$method->getName()]['return'] = $method->getReturnType()->toString();
        	}
        	else {
        	   $result[$method->getName()]['return'] = null;
        	}
        	$result[$method->getName()]['isWebMethod'] = $method->isWebmethod();
        	$result[$method->getName()]['isRestMethod']
        	                                  = $method->isTagged('restmethod');

        	$result[$method->getName()]['LoC'] = $method->getEndLine() - $method->getStartLine();

        	$result[$method->getName()]['paramCount'] = $method->getNumberOfParameters();
        	$result[$method->getName()]['reqParamCount'] = $method->getNumberOfRequiredParameters();

            $paramFlaws = 0;
            $result[$method->getName()]['params'] =
                     self::summarizeFunctionParameters($method, $paramFlaws);

        	$missingParamTypes += $paramFlaws;
        	$result[$method->getName()]['paramflaws'] = $paramFlaws;
        }
        return $result;
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
            $class = new iscReflectionClassType($className);

            $result[$className] = self::summarizeClassSignature($class);
            $result[$className]['interfaceCount'] = count($result[$className]['interfaces']);

            $result[$className]['properties'] = self::summarizeClassProperties($class);
            $result[$className]['propertyCount'] = count($result[$className]['properties']);

            $missingMethodComments = 0;
            $missingParamTypes = 0;
            $result[$className]['methods'] = self::summarizeClassMethods($class,
                                                         $missingMethodComments,
                                                         $missingParamTypes);
            $result[$className]['methodCount'] = count($result[$className]['methods']);
            $result[$className]['nonePrivateMethods'] = 0;
            $result[$className]['inheritedMethods'] = 0;
            $result[$className]['overriddenMethods'] = 0;
            foreach ($result[$className]['methods'] as $method) {
            	if (!$method['isPrivate']) {
            	    ++$result[$className]['nonePrivateMethods'];
            	}
            	if ($method['isOverridden']) {
            	    ++$result[$className]['overriddenMethods'];
            	}
            	if ($method['isInherited']) {
            	    ++$result[$className]['inheritedMethods'];
            	}
            }

            $result[$className]['missingMethodComments'] = $missingMethodComments;
            $result[$className]['missingParamTypes'] = $missingParamTypes;
            $result[$className]['children'] = 0;
        }

        foreach ($classes as $className) {
            if ($result[$className]['parentClass'] != null) {
                if (isset($result[$result[$className]['parentClass']])) {
                    ++$result[$result[$className]['parentClass']]['children'];
                }
            }
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
            	   $functs[$funcName]['tags'][] = $tag->getName();
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