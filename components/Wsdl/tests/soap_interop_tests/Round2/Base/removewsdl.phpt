--TEST--
SOAP Interop Round2 base cleanup
--FILE--
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */
$wsdl_file = dirname(__FILE__) . '/round2_base.wsdl';
//var_dump(unlink($wsdl_file));
?>
--EXPECT--
