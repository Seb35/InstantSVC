<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** File     - a collection of file related operations                    **
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

//***** File ****************************************************************
/**
 * Collection of File related operations
 * Should be implemented as static
 *
 * @package    libs.misc
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @static
 */
class File {

    //=======================================================================
    /**
     * Returns a realtive path of $absolute based on $base
     *
     * @param string $base
     * @param string $absolute
     * @return string
     */
    public static function absolutePathToRelativePath($base, $absolute) {
        $base = strtr($base, '\\/', DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR);
        $absolute = strtr($absolute, '\\/', DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR);

        $root = explode(DIRECTORY_SEPARATOR, $base);
        $rPath = explode(DIRECTORY_SEPARATOR, $absolute);

        $result = '';

        $curP = array_shift($rPath);
        $curR = array_shift($root);
        while ($curP == $curR) {
            $curP = array_shift($rPath);
        	$curR = array_shift($root);
        }

        if ($curP != null) array_unshift($rPath, $curP);
        if ($curR != null) array_unshift($root,  $curR);
        $result = str_repeat('..'.DIRECTORY_SEPARATOR, count($root));
        $result.= join(DIRECTORY_SEPARATOR, $rPath);

        //hack for include_once problems
        //there is a problem with useing \ in pathnames on include_once
        //a file could be included multiple times
        $result = strtr($result, DIRECTORY_SEPARATOR, '/');
        return $result;
    }
}

?>