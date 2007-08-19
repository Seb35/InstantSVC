<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** ezcReflectionTypeMapperImpl - implements type mapping from string to Type          **
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

//***** ezcReflectionTypeFactoryImpl *****************************************************
/**
 * @package    Reflection
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class ezcReflectionTypeFactoryImpl implements ezcReflectionTypeFactory {

    private $mapper;

    public function __construct() {
        $this->mapper = ezcReflectionTypeMapper::getInstance();
    }

    /**
     * Creates a type object for given typename
     * @param string $typename
     * @return ezcReflectionType
     * @todo ArrayAccess stuff, how to handle? has to be implemented
     */
    public function getType($type) {
        $type = trim($type);
        //Gibt für void null zurück
        if ($type == null or strlen($type) < 1 or strtolower($type) == 'void') {
            return null;
        }
        //First check whether it is an primitive type
        if ($this->mapper->isPrimitive($type)) {
            return new ezcReflectionPrimitiveType($this->mapper->getType($type));
        }
        //then check whether it is an array type
        elseif ($this->mapper->isArray($type)) {
            return new ezcReflectionArrayType($type);
        }
        //else it has to be a user class
        else {
            return new ezcReflectionClassType($type);
        }
    }
}

?>