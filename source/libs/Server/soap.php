<?php
/**
 * SOAPServer
 * This server is implemented without class structur to avoid duplicate
 * class problems
 *
 * Server gets it's soap.dd.php deployment descriptor file and invokes
 * PHP5 Soap Server with or without using User Token Profile authentication
 * based on the deployment descriptor
 *
 * This Server can handle multiple soap services be mapping the request on the
 * service classes
 * A request URI is structured like http://example.com/soap.php/{ServiceClass}
 *
 * To avoid security problems only classes descriped in the dd are used.
 *
 * @package    soap
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 *
 * @todo f�r optimierung auf anfrage geschwindigkeit, k�nnte das parsen der
 *       header daten f�rs UTP direkt von der Extension erledigt werden, m�sste
 *       nur in den adaptern (w�re also nur f�r den wrapped style ohne weiteres
 *       m�glich) eine Security($params) Methode implementiert werden, die den
 *       CheckUserRunnable aufruft
 */


$dd = require(dirname(__FILE__).'/soap.dd.php');

/**
 * Returns the request path without SOAPServer base
 * @return string
 */
#conceptual function getRequestPath()
    if (!isset($_SERVER['PATH_INFO']) or strlen($_SERVER['PATH_INFO'])<1) {
        $pathParams = str_replace($_SERVER['SCRIPT_NAME'], '',
                                     $_SERVER['PHP_SELF']);
    }
    else {
        $pathParams = $_SERVER['PATH_INFO'];
    }
    $getRequestPath = substr($pathParams, 1);
#end function

//Check whether a full request was done
if ($getRequestPath !== false) {
    if (isset($dd[$getRequestPath])) {
        $service = $dd[$getRequestPath];

        //wsdl request?
        if (isset($_REQUEST['WSDL']) or isset($_REQUEST['wsdl'])) {
            header('Content-type: application/xml');
            echo file_get_contents($service['wsdlfile']);
            exit();
        }

        require_once($service['classfile']);

        $server = null;
        if ($service['utp']) {
            require_once('libs/phpSec/Server/ExtendedSoapServer.php');
            // include Security-Parser
            require_once('libs/phpSec/Server/Parser/XmlSoapSecParser.php');
            // include SoapHeader-Parser
            require_once('libs/phpSec/Server/Parser/XmlSoapHeaderParser.php');

            // init UsernameToken parser
            $xmlUserNameTokenParser = new XmlSoapSecParser();
            // init delete soap header parser
            $xmlSoapHeaderParser = new XmlSoapHeaderParser();

            //TODO: CheckUserRunnable muss mit in den dd aufgenommen werden
            $xmlUserNameTokenParser->addCheckUserRunnable(new CheckUserRunnable());
            $server = new ExtendedSoapServer($service['wsdlfile']);
            // set XmlHandler
            $server->addXmlHandler($xmlUserNameTokenParser);
            $server->addXmlHandler($xmlSoapHeaderParser);
        }
        else {
            $server = new SoapServer($service['wsdlfile']);
        }
        $server->setClass($service['classname']);
        $server->handle();
    }
}

?>