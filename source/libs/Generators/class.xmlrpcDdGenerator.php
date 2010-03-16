<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** XML-RPC-DeploymentDescriptorGenerator                                 **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    libs                                                      **
//** @author     Matthias Rumpf                                            **
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
 * @author     Matthias Rumpf
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class XmlrpcDeploymentDescriptorGenerator {

    /**
     * @var array<string, array<string, string[2]>>
     */
    private $ddArray;

    /**
     * @var string
     */
    private $ddFile = 'xmlrpc.dd.php';

    /**
     * @var string
     */
    private $deploymentPath = '.';

    /**
     * @var array<string,string>[]
     */
    protected $services;

    //=======================================================================
    /**
     *
     */
    public function __construct() {
    }

    //=======================================================================
    /**
     * Generates a XML-RPC deployment descriptor and saves it to the given or set
     * path. Default path is current working directory
     *
     * @param string $path
     */
    public function save($path = null) {
        if ($path != null) $this->setDeployPath($path);

        foreach ($this->services as $key => $value) {
            $this->services[$key]['classfile'] =
                             $this->makeBasedOnDeployPath($value['classfile']);
        }

        $ddArray = 'return '.var_export($this->services, true).';';

        $ddStr = "<?php\n";
        $ddStr.= "//** XML-RPC-Server Deployment Descriptor **//\n";
        $ddStr.= "//** constants **//\n\n";

        $ddStr.= "//** imports **//\n";
        $ddStr.= "\n";
        $ddStr.= "//** settings **//\n";
        $ddStr.= $ddArray;
        $ddStr.= "\n?>";

        $file = fopen($this->deploymentPath.'/'.$this->ddFile, 'w');
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
     * @param string $servicename
     * @param string $classfile
     * @param string $classname
     */
    public function addService($servicename, $classfile, $classname) {
        $service = array();
        $service['servicename'] = $servicename;
        $service['classfile']   = $classfile;
        $service['classname']   = $classname;
        $this->services[$servicename] = $service;
    }
}

?>