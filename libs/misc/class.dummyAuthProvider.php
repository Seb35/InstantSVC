<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** dummyAuthProvider - sample implementation of authProvider interface   **
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
require_once(dirname(__FILE__).'/interface.authProvider.php');

//***** dummyAuthProvider ***************************************************
/**
 * dummyAuthProvider is a sample implementation of authProvider and just
 * reverses the given account name and returns it as expected password
 *
 * @package    libs.misc
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class dummyAuthProvider implements authProvider {

    //=========================================================================
    /**
     * Dummy implementation, returns $accountName reversed
     *
     * @param string $accountName
     * @return string
     */
    function getPassword($accountName) {
        return strrev($accountName);
    }

    //=========================================================================
    /**
     * @return boolean
     */
    function isMd5() {
        return false;
    }

    //=========================================================================
    /**
     * @return boolean
     */
    function isPlain() {
        return true;
    }

    //=========================================================================
    /**
     * @return mixed
     */
    function getAlternativeEncryptionMethod() {
        return null;
    }

    //=========================================================================
    /**
     * @return boolean
     */
    function isRFC2617Md5() {
        return false;
    }
}

?>