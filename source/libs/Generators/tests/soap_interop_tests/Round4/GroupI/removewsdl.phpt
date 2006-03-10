--TEST--
SOAP Interop Round4 GroupI XSD cleanup
--FILE--
<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 filetype=php: */
//var_dump(unlink(dirname(__FILE__) . '/round4_groupI_xsd.wsdl'));
//var_dump(unlink(dirname(__FILE__) . '/class.SOAP_Interop_GroupIDocumentWrappedAdapter.php'));
?>
--EXPECT--
bool(true)
bool(true)
