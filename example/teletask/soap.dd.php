<?php
//** SOAPServer Deployment Descriptor **//
//** generated via generateRestDd.php **//

//** constants **//

//** imports **//
require_once('../../source/libs/Server/class.ExtendedSoapServer.php');

require_once('../../source/libs/UserTokenProfile/XmlSoapSecParser.php');

require_once('../../source/libs/SoapHeader/XmlSoapHeaderParser.php');

require_once('../../source/libs/UserTokenProfile/CheckUserRunnable.php');


//** settings **//
return array (
  'queryLecture' => 
  array (
    'wsdlfile' => 'queryLecture.wsdl',
    'servicename' => 'queryLecture',
    'utp' => true,
    'classfile' => 'class.queryLectureDocumentWrappedAdapter.php',
    'classname' => 'queryLectureDocumentWrappedAdapter',
  ),
);
?>