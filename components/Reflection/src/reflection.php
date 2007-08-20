<?php
/**
 * File containing the ezcReflectionApi class.
 *
 * @package Reflection
 * @version //autogentag//
 * @copyright Copyright (C) 2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Holds type factory for generating type objects by given name
 * 
 * @package Reflection
 * @version //autogentag//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class ezcReflectionApi {

	/**
	* @var ezcReflectionApi
	*/
	private static $instance = null;

	/**
	 * @var ezcReflectionTypeFactory
	 */
	private $ezcReflectionTypeFactory = null;


    private function __construct() {

    }

    /**
    * @return ezcReflectionApi
    */
    public static function getInstance() {
    	if (self::$instance == null) {
    		self::$instance = new ezcReflectionApi();
    	}
        return self::$instance;
    }

    /**
     * Factory to create type objects
     * @param ezcReflectionTypeFactory $factory
     * @return void
     */
    public function setezcReflectionTypeFactory($factory) {
        $this->ezcReflectionTypeFactory = $factory;
    }

    /**
     * Returns a ezcReflectionType object for the given type name
     *
     * @param string $typeName
     * @return ezcReflectionType
     */
    public function getTypeByName($typeName) {
        if ($this->ezcReflectionTypeFactory == null) {
            $this->ezcReflectionTypeFactory = new ezcReflectionTypeFactoryImpl();
        }
        return $this->ezcReflectionTypeFactory->getType($typeName);
    }
}

?>