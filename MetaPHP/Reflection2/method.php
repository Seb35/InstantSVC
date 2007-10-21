<?php
require_once(dirname(__FILE__) . '/class.php');

/**
 * File containing the ezcReflectionMethod class.
 *
 * @package Reflection
 * @version //autogentag//
 * @copyright Copyright (C) 2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Extends the ReflectionMethod class using PHPDoc comments to provide
 * type information
 * 
 * @package Reflection
 * @version //autogentag//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class iscReflectionMethod extends ezcReflectionMethod
{
    private $code = null;
    
    public function getCode() {
    	if ($this->code == null) {
    		if ($this->isInternal()) {
	    		$this->code = '/** Is internal Method, no code to display! **/';
	    	} else {
	    		$filename = $this->getDeclaringClass()->getFileName();
	    		$lines = file($filename);
	    		$start = $this->getStartLine();
	    		$end = $this->getEndLine();
	    		
	    		$code = '';
	    		foreach ($lines as $i => $line) {
	    			if ($i >= $start && $i < $end - 1) {
	    				$code .= $line;
	    			}
	    		}
	    		
	    		$this->code = $code;
	    	}
    	}
    	return $this->code;
    }
    
    public function setCode($code) {
    	if (function_exists('runkit_lint') && !runkit_lint($code)) {
    		throw new Exception('Code doesnt compile. Please correct error and try again.', 77);
    	}
    	$this->code = $code;
    	
    	$className = $this->getDeclaringClass()->getName();
    	$methodName = $this->getName();
    	$args = '';
    	$params = $this->getParameters();
    	foreach ($params as $param) {
    		if ($args == '') {
    			$args = $param->getName();
    		} else {
    			$args .= ','.$param->getName();
    		}
    	}
    
    	if ($this->isPrivate()) {
    		$flags = RUNKIT_ACC_PRIVATE;
    	} else if ($this->isProtected()) {
    		$flags = RUNKIT_ACC_PROTECTED;
    	} else if ($this->isPublic()) {
    		$flags = RUNKIT_ACC_PUBLIC;
    	}
    	
    	echo 'Tring to set following code: '. $code;
    	
    	if (!runkit_method_redefine($className, $methodName, $args, $code , $flags)) {
    		throw new Exception('Code couldnt be set. May be this method is on the current call stack?.', 78);
    	}
    }
	
	
    /**
     * @return ezcReflectionClassType
     */
    function getDeclaringClass() {
        $class = parent::getDeclaringClass();
		if (!empty($class)) {
		    return new iscReflectionClass($class->getName());
		}
		else {
		    return null;
		}
    }
}
?>