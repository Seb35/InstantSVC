<?php

//***************************************************************************
//***************************************************************************
//**                                                                       **
//** XML-RPC-Server - This server is implemented without class structur    **
//**                  to avoid duplicate class problems                    **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package    xmlrpc                                                    **
//** @author     Matthias Rumpf                                            **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//**                                                                       **
//***************************************************************************
//***************************************************************************

/**
 * XML-RPC-Server
 * This server is implemented without class structur to avoid duplicate
 * class problems
 *
 * Server gets it's xmlrpc.dd.php deployment descriptor file and invokes
 * PHP5 XML-RPC Server based on the deployment descriptor
 *
 * This Server can handle multiple xml-rpc services by mapping the request on the
 * service classes
 * A request URI is structured like http://example.com/xmlrpc.php/{ServiceClass}
 *
 * To avoid security problems only classes descriped in the dd are used.
 *
 * @package    xmlrpc
 * @author     Matthias Rumpf
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */

$dd = require(dirname(__FILE__).'/xmlrpc.dd.php');

/**
 * Returns the request path without XML-RPC-Server base
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

        require_once($service['classfile']);
    $rpcServer = xmlrpc_server_create();
        $class = new $service['classname']($rpcServer);
    $resp = xmlrpc_server_call_method($rpcServer,$HTTP_RAW_POST_DATA,null);
    if ($resp) {
        header ('Content-Type: text/xml');
        echo $resp;
    }
    xmlrpc_server_destroy($rpcServer);
    
    } //end if
} //end if

?>