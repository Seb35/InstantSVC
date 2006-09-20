<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** iscReflectionApi - Main Class, holds type factory                **
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

//***** iscReflectionApi ***********************************************
/**
* Holds type factory for generating type objects by given name
*
* @package    Reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class iscReflectionApi {

	/**
	* @var iscReflectionApi
	*/
	private static $instance = null;

	/**
	 * @var iscReflectionTypeFactory
	 */
	private $iscReflectionTypeFactory = null;


    //=======================================================================
    private function __construct() {

    }

    //=======================================================================
    /**
    * @return iscReflectionApi
    */
    public static function getInstance() {
    	if (self::$instance == null) {
    		self::$instance = new iscReflectionApi();
    	}
        return self::$instance;
    }

    //=======================================================================
    /**
     * Factory to create type objects
     * @param iscReflectionTypeFactory $factory
     * @return void
     */
    public function setiscReflectionTypeFactory($factory) {
        $this->iscReflectionTypeFactory = $factory;
    }

    //=======================================================================
    /**
     * Returns a iscReflectionType object for the given typename
     *
     * @param string $typeName
     * @return iscReflectionType
     */
    public function getTypeByName($typeName) {
        if ($this->iscReflectionTypeFactory == null) {
            $this->iscReflectionTypeFactory = new iscReflectionTypeFactoryImpl();
        }
        return $this->iscReflectionTypeFactory->getType($typeName);
    }
}

?>