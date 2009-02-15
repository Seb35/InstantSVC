<?php
define ('AT_ROOT', dirname(__FILE__));
define ('ADODB_DIR', dirname(__FILE__) . '/../../../../adodb/');
define ('SMARTY_DIR', dirname(__FILE__) . '/../../../../smarty/');
define ('AT_SMARTY_TEMP_DIR', dirname(__FILE__) . '/../../');
define ('PHP_BIN_PATH', 'php');

// default directory to search for service implementations
define ('STD_SEARCHPATH', $_SERVER['DOCUMENT_ROOT'] . '/service-implementations/');

// InstantSVC will refuse to generate files outside of this directory
define ('INSTANTSVC_GENERATION_BASE_DIR', $_SERVER['DOCUMENT_ROOT']);

// default target directory for generated files
define ('INSTANTSVC_DEFAULT_TARGET_DIR', $_SERVER['DOCUMENT_ROOT'] . '/services/');

// default service URI used as WSDL namespace and service endpoint URL
if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
    define ('INSTANTSVC_DEFAULT_SERVICE_URI', 'https://' . $_SERVER['HTTP_HOST'] . '/services/soap.php/');
} else {
    define ('INSTANTSVC_DEFAULT_SERVICE_URI', 'http://' . $_SERVER['HTTP_HOST'] . '/services/soap.php/');
}
?>
