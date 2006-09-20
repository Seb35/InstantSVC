<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ExtendedReflectionApi - Main Class, holds type factory                **
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

//***** ExtendedReflectionApi ***********************************************
/**
* Holds type factory for generating type objects by given name
*
* @package    libs.reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class ExtendedReflectionApi {

	/**
	* @var ExtendedReflectionApi
	*/
	private static $instance = null;

	/**
	 * @var TypeFactory
	 */
	private $typeFactory = null;


    //=======================================================================
    private function __construct() {

    }

    //=======================================================================
    /**
    * @return ExtendedReflectionApi
    */
    public static function getInstance() {
    	if (self::$instance == null) {
    		self::$instance = new ExtendedReflectionApi();
    	}
        return self::$instance;
    }

    //=======================================================================
    /**
     * Factory to create type objects
     * @param TypeFactory $factory
     * @return void
     */
    public function setTypeFactory($factory) {
        $this->typeFactory = $factory;
    }

    //=======================================================================
    /**
     * Returns a Type object for the given typename
     *
     * @param string $typeName
     * @return Type
     */
    public function getTypeByName($typeName) {
        if ($this->typeFactory == null) {
            $this->typeFactory = new TypeFactoryImpl();
        }
        return $this->typeFactory->getType($typeName);
    }
}

?>