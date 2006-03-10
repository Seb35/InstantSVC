<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** TypeMapper - Provides mapping between different type names used in    **
//**              documentation                                            **
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

//***** TypeMapper **********************************************************
/**
* Provides mapping from type names used in documentation to standardized
* type names
*
* @package    libs.reflection
* @author     Stefan Marr <mail@stefan-marr.de>
* @copyright  2006 ....
* @license    http://www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
*/
class TypeMapper {

	/**
	* @var TypeMapper
	*/
	private static $instance = null;

    /**
    * @var array<string,string>
    */
    protected $mappingTable;

    /**
    * @var array<string,string>
    */
    protected $xmlMappingTable;

    //=======================================================================
    private function __construct() {
        $this->initMappingTable();
    }

    //=======================================================================
    /**
    * @return TypeMapper
    */
    public static function getInstance() {
    	if (self::$instance == null) {
    		self::$instance = new TypeMapper();
    	}
        return self::$instance;
    }

    //=======================================================================
    protected function initMappingTable() {
    	$boolean = 'boolean';
    	$integer = 'integer';
    	$float   = 'float';
    	$string  = 'string';
    	$array   = 'array';
    	$mixed   = 'mixed';
    	$void    = 'void';
    	$object  = 'object';

    	$this->mappingTable['int']     = $integer;
    	$this->mappingTable['integer'] = $integer;
    	$this->mappingTable['long']    = $integer;
    	$this->mappingTable['short']   = $integer;
    	$this->mappingTable['byte']    = $integer;

    	$this->mappingTable['boolean'] = $boolean;
    	$this->mappingTable['bool']	   = $boolean;
    	$this->mappingTable['true']	   = $boolean;
    	$this->mappingTable['false']   = $boolean;

    	$this->mappingTable['float']   = $float;
    	$this->mappingTable['double']  = $float;

    	$this->mappingTable['string']  = $string;
    	$this->mappingTable['char']    = $string;

    	$this->mappingTable['array']   = $array;
    	$this->mappingTable['mixed']   = $mixed;
    	$this->mappingTable['void']    = $void;
    	$this->mappingTable['object']  = $object;

    	$this->xmlMappingTable[$boolean] = 'xsd:'.$boolean;
    	$this->xmlMappingTable[$integer] = 'xsd:int';
    	$this->xmlMappingTable[$float]   = 'xsd:float';
    	$this->xmlMappingTable[$string]  = 'xsd:string';
    }

    //=======================================================================
    /**
    * Maps a type to a standard type name
    * @param string $type
    * @return string
    */
    public function getType($type) {
        if (isset($this->mappingTable[strtolower($type)])) {
    		return $this->mappingTable[strtolower($type)];
    	}
    	else {
    		return $type;
    	}
    }

    //=======================================================================
    /**
    * Maps a type to a standard xml type name
    * @param string $type
    * @return string
    */
    public function getXmlType($type) {
        if (isset($this->xmlMappingTable[strtolower($type)])) {
    		return $this->xmlMappingTable[strtolower($type)];
    	}
    	else {
    		return null;
    	}
    }

    //=======================================================================
    /**
    * Test whether the given type is a primitive type
    * @param string $type
    * @return boolean
    */
    public function isPrimitive($type) {
        if ($this->getType($type) != 'array' and
                isset($this->mappingTable[strtolower($type)])) {
            return true;
        }
        return false;
    }

    //=======================================================================
    /**
    * Test whether the given type is an array or array map
    * @param string $type
    * @return boolean
    */
    public function isArray($type) {
        $type = trim($type);
        if (strlen($type) > 0) {
            //last char is ] so it should be something like array[]
            if ($type{strlen($type)-1} == ']') {
                return true;
            }
            //my be the auther just wrote 'array'
            if ($type == 'array') {
                return true;
            }

            //test for array map types
            elseif (preg_match('/(.*)(<(.*?)(,(.*?))?>)/', $type)) {
                return true;
            }
        }
        return false;
    }
}
?>