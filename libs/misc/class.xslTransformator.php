<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** xslTransformator.php								   **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    libs.misc                                                 **
//** @author     Stefan Marr <mail@stefan-marr.de>                         **
//** @copyright  2006 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** XslTransformator ****************************************************
/**
 * @package    libs.misc
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class XslTransformator {
    /**
     * @var array<string,mixed>
     */
    protected $arguments;

    /**
     * @var string
     */
    protected $data;

    //=======================================================================
    /**
     * @param string $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    //=======================================================================
    public function process() {
        $x = new XSLTProcessor();
        //$x->
    }
}

?>