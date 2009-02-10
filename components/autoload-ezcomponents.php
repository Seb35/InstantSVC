<?php
require_once dirname( __FILE__ ) . '/Base/src/base.php';

//ezcBase::addClassRepository( realpath(dirname(__FILE__) . '/../lib/instantsvc/components'), realpath(dirname(__FILE__) . '/../lib/instantsvc/components/autoload'), 'isc' );

// define an __autoload function which is automatically called in case a class
// is used which hasn't been declared
function __autoload( $className ) {
    ezcBase::autoload( $className );
}
