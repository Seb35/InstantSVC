<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ezcReflectionApi - Main Class, holds type factory                **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    reflection                                                **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** ezcReflectionApi ***********************************************
/**
* Holds type factory for generating type objects by given name
*
* @package    Reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
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


    //=======================================================================
    private function __construct() {

    }

    //=======================================================================
    /**
    * @return ezcReflectionApi
    */
    public static function getInstance() {
    	if (self::$instance == null) {
    		self::$instance = new ezcReflectionApi();
    	}
        return self::$instance;
    }

    //=======================================================================
    /**
     * Factory to create type objects
     * @param ezcReflectionTypeFactory $factory
     * @return void
     */
    public function setezcReflectionTypeFactory($factory) {
        $this->ezcReflectionTypeFactory = $factory;
    }

    //=======================================================================
    /**
     * Returns a ezcReflectionType object for the given typename
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