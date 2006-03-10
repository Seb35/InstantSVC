<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** authProvider - this interface is should be implemented by             **
//**                a user managment facility to provide user login        **
//**                capabilities to different authentication algorithms    **
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

//***** authProvider ********************************************************
/**
 * This interface is should be implemented by a user managment facility
 * to provide user login capabilities to different authentication algorithms
 *
 * @package    libs.misc
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
interface authProvider {

    /**
     * Returns the users password
     * If it is a plain or a md5 value should be checked
     * @param string $accountName
     * @param string $type
     * @return string
     */
    function getPassword($accountName, $type = null);

    /**
     * Returns whether the password will be provided as plaintext
     * by getPassword
     * @return boolean
     */
    function isPlain();

    /**
     * Returns true if getPassword returns password md5 encrypted
     * @return boolean
     */
    function isMd5();

    /**
     * Is true if getPassword returns md5(username:realm:passwd)
     * @return boolean
     */
    function isRFC2617Md5();

    /**
     * Return preferd password type, supported by implementation
     * @return string
     */
    function getPasswordType();

    /**
     * If not md5 and not plaintext return the used method
     * is call via call_user_func
     * @return mixed
     */
    function getAlternativeEncryptionMethod();
}

?>