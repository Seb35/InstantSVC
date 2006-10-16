<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** AdminToolSmartyConnect - Init Smarty                                  **
//**                                                                       **
//** Project: Web Services Description Generator                           **
//**                                                                       **
//** @package    admintool                                                 **
//** @author     Martin Sprengel <martin.sprengel@hpi.uni-potsdam.de>      **
//** @copyright  2006 ....                                                 **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

//***** imports *************************************************************
require_once(dirname(__FILE__).'/admin-tool-config.php');
require_once(SMARTY_DIR.'Smarty.class.php');

//***** AdminToolApp ********************************************************
/**
 * @package    admintool
 * @author     Martin Sprengel <martin.sprengel@hpi.uni-potsdam.de>
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class AdminToolSmartyConnect extends Smarty {

    //=======================================================================
    function __construct() {
        // Class Constructor.
        // These automatically get set with each new instance.
        parent::__construct();

        $this->left_delimiter = '{{';
        $this->right_delimiter = '}}';
        $this->template_dir = AT_SMARTY_TEMP_DIR . '/templates';
        //$this->config_dir = $_SERVER['DOCUMENT_ROOT'] . '/smarty/configs';
        $this->compile_dir = AT_SMARTY_TEMP_DIR . '/templates_c';
        $this->cache_dir = SMARTY_DIR . '../cache';
    }
}
?>