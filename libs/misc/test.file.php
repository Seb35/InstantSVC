<?php

//***************************************************************************
//***************************************************************************
//**                                                                       **
//** CodeAnalyzer - searchs through source tree and collects infos about   **
//**                found classes and files                                **
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

//***** imports *************************************************************
require_once('PHPUnit2/Framework/TestCase.php');
require_once('class.file.php');

//***** FileTest ************************************************************
/**
 * @package    libs.misc
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class FileTest extends PHPUnit2_Framework_TestCase {

    //=======================================================================
    public function testAbsolutePathToRelativePath() {

        $result = File::absolutePathToRelativePath('C:\dsd\aaa', 'C:\dsd\sdfsdfd\fgfg\php.php');
        $this->assertEquals('..\sdfsdfd\fgfg\php.php', $result, 'Should be equal as result of convert from a2r.');

        $result = File::absolutePathToRelativePath('C:\dsd\aaa', 'C:\dsd\aaa\php.php');
        $this->assertEquals('php.php', $result, 'Should be equal as result of convert from a2r.');

        $result = File::absolutePathToRelativePath('C:\fsdf\sdfd\rtrt\rttrt', 'C:\php.php');
        $this->assertEquals('..\..\..\..\php.php', $result, 'Should be equal as result of convert from a2r.');

        $result = File::absolutePathToRelativePath('C:\fsdf\sdfd\rtrt\rttrt', 'C:\sdds\php.php');
        $this->assertEquals('..\..\..\..\sdds\php.php', $result, 'Should be equal as result of convert from a2r.');
    }
}

?>