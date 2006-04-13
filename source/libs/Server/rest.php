<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** RESTServer - his server is implemented without class structur to avoid duplicate                    **
//**                      class problems                            **
//**                                                                       **
//** Project: Web Services Security                                        **
//**                                                                       **
//** @package    rest                                               **
//** @author     Stefan Marr <mail@stefan-marr.de>    **
//** @copyright  2006 Stefan Marr                 **
//** @license www.apache.org/licenses/LICENSE-2.0   Apache License 2.0     **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** RESTServer **************************************************
/**
  * This server is implemented without class structur to avoid duplicate
 * class problems
 *
 * This server includes a rest.dd.php deployment descriptor with informations
 * about request mappings, authentication and serializers to be used.
 *
 * @todo Serializer TESTEN MIT instanceof Serializer
 * @package    rest
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */

error_reporting(E_ALL);

//require_once('../libs/class.digestAuth.php');

/**
 * Returns the request path without RESTServer base
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
    $getRequestPath = $pathParams;
#end function


/* Start handling request to RESTServer */
$restDD = include('rest.dd.php'); //Load deployment descriptor
$request = $getRequestPath/*()*/;

if (isset($restDD['authentication']) and
    $restDD['authentication'] != 'none') {
    switch ($restDD['authentication']) {
    	case 'digest':
    	    if (isset($restDD['auth-settings']['digest']['provider'])) {
    	        $providerClass = $restDD['auth-settings']['digest']['provider'];
    	        if (!class_exists($providerClass)) {
    	            echo (__FILE__.':'.__LINE__);
    	            return;
    	        }
        	    $auth = new DigestAuth(new $providerClass());
                if (!$auth->loggedIn()) {
                    $auth->authenticate();
                }
            }
            else {
                die('Deployment descriptor is incomplete.');
            }
    		break;

    	default:
    		break;
    }
} //end if

/** look through mapping and call method */
$requestMethod = $_SERVER['REQUEST_METHOD'];
foreach ($restDD['mapping'] as $pattern => $methods) {
	if (preg_match($pattern, $request, $matches)) {
	    if (isset($methods[$requestMethod])) {
	        //choose deserializer
	        if (!isset($unSerClass) or empty($unSerClass)) {
                $unSerClass = $methods[$requestMethod]['in'];
            }

            if (!isset($unSerClass) or empty($unSerClass)) {
                $unSerClass = $restDD['serializer']['in'];
            }

            //choose serializer
            if (isset($_REQUEST['f'])) {
	            if (isset($restDD['serializer']['map'][$_REQUEST['f']])) {
	                $serClass = $restDD['serializer']['map'][$_REQUEST['f']];
	            }
	        }
	        if (!isset($serClass) or empty($serClass)) {
                $serClass = $methods[$requestMethod]['out'];
            }

            if (!isset($serClass) or empty($serClass)) {
                $serClass = $restDD['serializer']['out'];
            }

	        if ($requestMethod == 'POST' or $requestMethod == 'PUT') {
	            //Get content from stdin if it's a PUT or POST request
                //$requestData = '';
                //$httpContent = fopen('php://input', 'r');
                //while ($data = fread($httpContent, 1024)) {
                //    $requestData .= $data;
                //}
                //fclose($httpContent);
                $requestData = file_get_contents('php://input');

                if (class_exists($unSerClass)) {
                    $unSer = new $unSerClass();
                    $data = $unSer->deserialize($requestData);
                }
                else {
                    die('Can\'t process input data, deserializer not found');
                }
	        }
	        $params = array();
	        for ($i = 1; $i < count($matches); $i++) {
	            $params[] = $matches[$i];
	        }

            if (isset($data) and (is_object($data) or is_array($data))) {
	            $params[] = $data;
	        }

	        //May be we have a singleton class, just check for some common names
            if (is_callable(array($methods[$requestMethod]['c'], '__contruct'), false)) {
	           $obj = new $methods[$requestMethod]['c']();
            }
            elseif (is_callable(array($methods[$requestMethod]['c'], 'getInstance'), false)) {
	           $obj = call_user_func(array($methods[$requestMethod]['c'], 'getInstance'));
            }
            elseif (is_callable(array($methods[$requestMethod]['c'], 'getSingleton'), false)) {
	           $obj = call_user_func(array($methods[$requestMethod]['c'], 'getSingleton'));
            }

            ob_start();
	        $result = call_user_func_array(array($obj, $methods[$requestMethod]['m']), $params);
	        ob_end_clean();

	        if (!empty($result)) {
    	        if (class_exists($serClass)) {
                    $unSer = new $serClass();
                    echo $unSer->serialize($result);
                }
                else {
                    die('Can\'t process input data, serializer not found');
                }
	        }
            return;
	    } //end if
	} //end if
} //end foreach

?>