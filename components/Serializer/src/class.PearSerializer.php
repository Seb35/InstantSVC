<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** PearSerializer - combines the pear serializer and unserializer        **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    libs.misc                                                 **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once('interface.serializer.php');
require_once('class.serializer.php');
require_once('class.unserializer.php');

//***** PearSerializer ******************************************************
/**
 * Combines the PEAR XML_Serializer and XML_Unserializer implemnting the
 * Serializer interface to be used e.g. by the REST Server
 * @package    libs.misc
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class PearSerializer implements Serializer {

    /**
     * @var array<string,mixed>
     */
    protected $options;

    /**
     * @var XML_Serializer
     */
    protected static $serializer = null;

    /**
     * @var XML_Unserializer
     */
    protected static $deserializer = null;

    //=======================================================================
    public function __construct() {
        $this->options = array(
                            'indent'     => '    ',
                            'linebreak'  => "\n",
                            'typeHints'  => false,
                            'addDecl'    => true,
                            'defaultTag' => 'item',
                            'encoding'   => 'UTF-8'  //"ISO-8859-1"
                         );
    }

    //=======================================================================
    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data) {
        if (self::$serializer == null) {
            self::$serializer = new XML_Serializer($this->options);
        }

        self::$serializer->serialize($data, array('classAsTagName' => true));
        return self::$serializer->getSerializedData();
    }

    //=======================================================================
    /**
     * @param string $str
     * @return mixed
     */
    public function deserialize($str) {
        if (self::$deserializer == null) {
            self::$deserializer = new XML_Unserializer();
        }

        $data = self::$deserializer->unserialize($str);
        if ($data === true) {
            $data = self::$deserializer->getUnserializedData();
        }

        return $data;
    }
}

?>