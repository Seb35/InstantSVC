<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** RestDeploymentDescriptorGenerator - generate php files for optimized  **
//**                                     request performance               **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    libs                                                      **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/../../../libs/reflection/class.ClassType.php');
require_once(dirname(__FILE__).'/../../../libs/misc/class.file.php');

//***** RestDeploymentDescriptorGenerator ***********************************
/**
 * @package    libs.generator
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class iscRestDdGenerator {

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var string[]
     */
    private $classes;

    /**
     * @var string[]
     */
    private $webClasses = null;


    /**
     * @var ExtReflectionMethod[]
     */
    private $methods = array();

    /**
     * @var array<string, array<string, string[2]>>
     */
    private $ddArray;

    /**
     * @var string[]
     */
    private $requires = array();

    /**
     * @var string
     */
    private $ddFile = 'rest.dd.php';

    /**
     * @var array<string,string>
     */
    private $formatMapping;

    /**
     * @var string
     */
    private $standardSerializer;

    /**
     * @var string
     */
    private $standardDeserializer;

    /**
     * @var string
     */
    private $authType;

    /**
     * @var string
     */
    private $authProvider;

    /**
     * @var string
     */
    private $deploymentPath = '.';

    //=========================================================================
    /**
     * @param string[] $classes Array with Classnames to work on
     */
    public function __construct($classes) {
        $this->classes = $classes;
    }

    //=========================================================================
    /**
     * Generates a REST deployment descriptor and saves it to the given or set
     * path. Default path is current working directory
     *
     * @param string $path
     */
    public function save($path = null) {
        if ($path != null) $this->setDeployPath($path);
        $this->collectRestMethods();
        $this->buildDd();

        $this->requires = array_unique($this->requires);


        $req = '';
        foreach ($this->requires as $require) {
            $req.= 'require_once(\''.$require.'\');'."\n";
        }


        $ddArray = 'return '.var_export($this->ddArray, true).';';

        $ddStr = "<?php\n";
        $ddStr.= "//** RESTServer Deployment Descriptor **//\n";
        $ddStr.= "//** generated via generateRestDd.php **//\n\n";
        $ddStr.= "//** constants **//\n";
        if (!empty($this->baseUri)) {
            $ddStr.= "if (!defined('REST_BASE')) {\n";
            $ddStr.= "    define('REST_BASE', '".$this->baseUri."');\n";
            $ddStr.= "}\n\n";
        }
        $ddStr.= "//** imports **//\n";
        $ddStr.= $req."\n";
        $ddStr.= "//** settings **//\n";
        $ddStr.= $ddArray;
        $ddStr.= "\n?>";

        file_put_contents($this->deploymentPath.'/'.$this->ddFile, $ddStr);
    }

    //=========================================================================
    /**
     * Parses given classes for methods tagged with @restmethod
     */
    public function collectRestMethods() {
        if ($this->webClasses == null) {
            foreach ($this->classes as $className) {
                $class = new ClassType($className);
                if ($class->isTagged('webservice')) {
                    $this->webClasses[] = $className;
                    $methods = $class->getMethods();

                    foreach ($methods as $method) {
                    	if ($method->isTagged('restmethod')) {
                    	    $this->methods[] = $method;
                    	}
                    }
                }
            }
        }
    }

    //=========================================================================
    /**
     * Collects all information to build a deployment descriptor
     */
    public function buildDd() {
        foreach ($this->methods as $method) {
            $this->requires[] = $this->makeBasedOnDeployPath(
                                   $method->getDeclaringClass()->getFileName());

            $inClassName = null;
            $outClassName = null;

            $ins = $method->getTags('restin');
            if (isset($ins[0]) and $ins[0] instanceof PHPDocRestInTag) {
                $inClassName = $ins[0]->getSerializer();
                $inClass = new ReflectionClass($inClassName);
                $this->requires[] = $this->makeBasedOnDeployPath($inClass->getFileName());
            }
            $outs = $method->getTags('restout');
            if (isset($outs[0]) and $outs[0] instanceof PHPDocRestOutTag) {
                $outClassName = $outs[0]->getSerializer();
                $outClass = new ReflectionClass($outClassName);
                $this->requires[] = $this->makeBasedOnDeployPath($outClass->getFileName());
            }

            $tags = $method->getTags('restmethod');
            foreach ($tags as $tag) {
            	$this->ddArray['mapping'][$tag->getRequestPattern()][$tag->getHttpMethod()]
            	               = array('c'  => $method->getDeclaringClass()->getName(),
            	                       'm'  => $method->getName(),
            	                       'in' => $inClassName,
            	                       'out'=> $outClassName);
            }
        }


        $this->ddArray['authentication'] = $this->authType;
        $this->ddArray['auth-settings'][$this->authType]['provider'] = $this->authProvider; // class name
        $this->ddArray['serializer']['in'] = $this->standardSerializer;
        $this->ddArray['serializer']['out'] = $this->standardDeserializer;
        $this->ddArray['serializer']['map'] = $this->formatMapping;

        //Dateien ermitteln für alle classen in map
        if ($this->authType != 'none' and !empty($this->authType)) {
            $provider = new ReflectionClass($this->authProvider);
            $this->requires[] = $this->makeBasedOnDeployPath($provider->getFileName());
        }

        $ser = new ReflectionClass($this->standardSerializer);
        $this->requires[] = $this->makeBasedOnDeployPath($ser->getFileName());

        $ser = new ReflectionClass($this->standardDeserializer);
        $this->requires[] = $this->makeBasedOnDeployPath($ser->getFileName());

        if (is_array($this->formatMapping)) {
            foreach ($this->formatMapping as $className) {
            	$class = new ReflectionClass($className);
            	$this->requires[] = $this->makeBasedOnDeployPath($class->getFileName());
            }
        }
    }

    //=========================================================================
    /**
     * Set whether to use authentication, and if which type and provider
     *
     * @param boolean $use
     * @param string $authType
     * @param string $provider
     */
    public function useAuthentication($use, $authType = null, $provider = null) {
        if ($use) {
            if (!class_exists($provider)) {
                throw new Exception('Couldn\'t load auth provider class '.$provider);
            }
            $this->authType = $authType;
            $this->authProvider = $provider;
        }
        else {
            $this->authType = 'none';
            $this->authProvider = null;
        }
    }

    //=========================================================================
    /**
     * @param string $className
     */
    public function setStandardSerializer($className) {
        if (!class_exists($className, true)) {
            throw new Exception('Couldn\'t load serializer class '.$className);
        }
        $this->standardSerializer = $className;
    }

    //=========================================================================
    /**
     * @param string $className
     */
    public function setStandardDeserializer($className) {
        if (!class_exists($className, true)) {
            throw new Exception('Couldn\'t load deserializer class '.$className);
        }
        $this->standardDeserializer = $className;
    }

    //=========================================================================
    /**
     * @param string $path
     */
    public function setDeployPath($path) {
        $rPath = realpath($path);
        if ($rPath === false) {
            throw new Exception('Set path does not exist.');
        }
        $this->deploymentPath = $rPath;
    }

    //=========================================================================
    /**
     * @param array<string,string> $mappingTable
     */
    public function setFormatMapping($mappingTable) {
        $this->formatMapping = $mappingTable;
    }

    //=========================================================================
    /**
     * @param string $path
     */
    protected function makeBasedOnDeployPath($path) {
        $rPath = realpath($path);
        return File::absolutePathToRelativePath($this->deploymentPath, $rPath);
    }

    //=========================================================================
    /**
     * Returns classenames the generater should work on
     * @return string[]
     */
    public function getClasses() {
        return $this->classes;
    }

    //=========================================================================
    /**
     * Returns classnamesof identified @webservice classes
     * @return string
     */
    public function getWebClasses() {
        return $this->webClasses;
    }

    //=========================================================================
    /**
     * Returns expected output path for the deployment descriptor
     * @return string
     */
    public function getDeployFileName() {
        return $this->deploymentPath.DIRECTORY_SEPARATOR.$this->ddFile;
    }

    //=========================================================================
    /**
     * Sets base URI for server, will generate a REST_BASE constant in dd
     * @param string $uri
     */
    public function setBaseUri($uri) {
        $this->baseUri = $uri;
    }
}

?>