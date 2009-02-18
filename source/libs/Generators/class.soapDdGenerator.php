<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** SoapDeploymentDescriptorGenerator - generate php files for optimized  **
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

//***** SoapDeploymentDescriptorGenerator ***********************************
/**
 * @package    libs.generator
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @author     Falko Menge <mail@falko-menge.de>
 * @copyright  2006-2009 InstantSVC Team
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class SoapDeploymentDescriptorGenerator {

    /**
     * @var array<string, array<string, string[2]>>
     */
    private $ddArray;

    /**
     * @var string
     */
    private $ddFile = 'soap.dd.php';

    /**
     * @var string
     */
    private $deploymentPath = '.';

    /**
     * @var array<string,string>[]
     */
    protected $services;
    
    /**
     * @var boolean
     */
    protected $utpIncludes = false;

    /**
     * @var boolean
     *      Whether to append the service configurations to an existing
     *      deployment descriptor
     */
    protected $append = false;
    

    //=======================================================================
    /**
     * Constructor
     *
     * @param boolean $append
     *        Whether to append the service configurations to an existing
     *        deployment descriptor
     */
    public function __construct($append = false) {
        $this->append = $append;
    }

    /**
     * Sets whether to append the service configurations to an existing
     * deployment descriptor
     *
     * @param boolean $append
     *        Whether to append the service configurations to an existing
     *        deployment descriptor
     */
    public function setAppend($append = true) {
        $this->append = $append;
    }

    //=======================================================================
    /**
     * Generates a SOAP deployment descriptor and saves it to the given or set
     * path. Default path is current working directory
     *
     * @param string $path
     */
    public function save($path = null) {
        if ($path != null) $this->setDeployPath($path);
        $filename = $this->deploymentPath.'/'.$this->ddFile;
        if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }

        $services = $this->services;
        foreach ($services as $key => $value) {
        	$services[$key]['classfile'] =
        	                 $this->makeBasedOnDeployPath($value['classfile']);
            $services[$key]['urlprefix'] = $protocol . $_SERVER['HTTP_HOST'];
        }

        if ($this->append) {
            $existingServices = @include($filename);
            if (is_array($existingServices) and count($existingServices) > 0) {
                # merge existing and new services
                # services with the same name will be overwritten by the new version
                $services = array_merge($existingServices, $services);
            }
        }

        $ddArray = 'return '.var_export($services, true).';';

        $ddStr = "<?php\n";
        $ddStr.= "//** SOAPServer Deployment Descriptor **//\n";
        $ddStr.= "//** generated with InstantSVC **//\n\n";
        $ddStr.= "//** constants **//\n\n";

        $ddStr.= "//** imports **//\n";
        
        if ($this->utpIncludes) {
			$file = $this->makeBasedOnDeployPath(dirname(__FILE__).'/../Server/class.ExtendedSoapServer.php');
			$ddStr.= 'require_once(\''.$file.'\');'."\n\n";
			
			$file = $this->makeBasedOnDeployPath(dirname(__FILE__).'/../UserTokenProfile/XmlSoapSecParser.php');
			$ddStr.= 'require_once(\''.$file.'\');'."\n\n";
			
			$file = $this->makeBasedOnDeployPath(dirname(__FILE__).'/../SoapHeader/XmlSoapHeaderParser.php');
			$ddStr.= 'require_once(\''.$file.'\');'."\n\n";
			
			$file = $this->makeBasedOnDeployPath(dirname(__FILE__).'/../UserTokenProfile/CheckUserRunnable.php');
			$ddStr.= 'require_once(\''.$file.'\');'."\n\n";
        }
        $ddStr.= "\n";
        $ddStr.= "//** settings **//\n";
        $ddStr.= $ddArray;

        $file = fopen($filename, 'w');
        if ($file !== false) {
            fwrite($file, $ddStr);
            fclose($file);
        }
        else {
            throw new Exception('Can\'t write to deployment descriptor file');
        }
    }

    //=======================================================================
    /**
     * @param string $path
     */
    public function setDeployPath($path) {
        $this->deploymentPath = realpath($path);
    }

    //=======================================================================
    /**
     * @param string $path
     */
    protected function makeBasedOnDeployPath($path) {
        $rPath = realpath($path);
        return File::absolutePathToRelativePath($this->deploymentPath, $rPath);
    }

    //=======================================================================
    /**
     * Returns expected output path for the deployment descriptor
     * @return string
     */
    public function getDeployFileName() {
        return $this->deploymentPath.DIRECTORY_SEPARATOR.$this->ddFile;
    }

    //=======================================================================
    /**
     * @param string $wsdlfile
     * @param string $servicename
     * @param string $classfile
     * @param string $classname
     * @param boolean $utp
     */
    public function addService($wsdlfile, $servicename, $classfile,
                               $classname, $utp) {
        $service = array();
        $service['wsdlfile']    = $wsdlfile;
        $service['servicename'] = $servicename;
        $service['utp']         = $utp;
        $service['classfile']   = $classfile;
        $service['classname']   = $classname;
        $this->services[$servicename] = $service;
        if ($utp) {
			$this->utpIncludes = true;
        }
    }
}

?>
