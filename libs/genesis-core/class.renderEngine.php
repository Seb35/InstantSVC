<?php
//***************************************************************************
//***************************************************************************
//**                                                                       **
//** RenderEngine - inits and encapsulates the smarty template engine      **
//**                                                                       **
//** Project: TOOLSLAVE Genesis Framework                                  **
//**                                                                       **
//** @package    genesis-core                                              **
//** @author     Stefan Marr <marr@toolslave.com>                          **
//** @copyright  2006 Stefan Marr                                          **
//** @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0  **
//**                                                                       **
//***************************************************************************
//***************************************************************************

if (!defined('CODE_PATH')) {
    define('CODE_PATH', dirname(realpath(__FILE__.'/../')));
}

error_reporting(E_ALL);

//***** imports *************************************************************
include_once(SMARTY_DIR.'Smarty.class.php');

//***** wsRenderEngine ******************************************************
/**
 * Provides a initialized and preconfigured smarty template engine
 *
 * @package    libs.genesis-core
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @copyright  2006 Stefan Marr
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class RenderEngine {

  protected $_tpl = null;
  protected $_lang = null;
  protected $_data = null;
  protected $_smarty;
  protected $_raw = null;
  protected $_debug = null;
  protected $_tplfile = '';

  //=========================================================================
  /**
  * @param array $data
  * @param boolean $notStructured
  */
  public function __construct($data, $notStructured = true) {
    if ($notStructured) {
      $this->_raw = $data;
    }
    else {
      $this->_data = $data['data'];
      $this->_lang = $data['lang'];
      $this->_tpl  = $data['tpl'];
      if (isset($data['debug'])) {
        $this->_debug  = $data['debug'];
      }
      else {
        $this->_debug = null;
      }
    }

    //Initialisierung der Engine
    $this->_smarty = new Smarty();
    $this->_smarty->use_sub_dirs = false;
    $this->_smarty->left_delimiter = '{{';
    $this->_smarty->right_delimiter = '}}';
    $this->_smarty->compile_dir = CODE_PATH.'/templates_c';
    $this->_smarty->autoload_filters =
                          array('output' => array('trimwhitespace'));

    $this->_smarty->template_dir = CODE_PATH.'/templates';

    //$this->_smarty->default_resource_type = 'tpltree';
    $this->__tplfile = 'main.tpl.xhtml';

    //if (defined("GLOBAL_DEBUG") and GLOBAL_DEBUG) {
    $this->_smarty->debugging = true;
    //}
  }

  //=========================================================================
  /**
   * Displays rendered content to the browser
   * @param string $tpl
   */
  function display($tpl = null) {
    if ($tpl != null) {
      $this->setTemplate($tpl);
    }
    if ($this->_raw == null) {
      $this->_smarty->assign('data', $this->_data);
      $this->_smarty->assign('tpl', $this->_tpl);
      $this->_smarty->assign('lang', $this->_lang);
      if ($this->_debug != null) {
        $this->_smarty->assign('debug', $this->_debug);
      }
    }
    else {
      foreach ($this->_raw as $key => $value) {
        $this->_smarty->assign($key, $value);
      }
    }
    $this->_smarty->assign('asblock', false);
    $this->_smarty->display($this->__tplfile);
  }

  //=========================================================================
  /**
   * Returns string with rendered content instead displaying it to the
   * browser
   * @param string[optional] $tplfile
   * @param boolean[optional] $asBlock
   * @return string
   */
  public function fetch($tplfile = '', $asBlock = false) {
    if ($this->_raw == null) {
      $this->_smarty->assign('data', $this->_data);
      $this->_smarty->assign('tpl', $this->_tpl);
      $this->_smarty->assign('lang', $this->_lang);
      if ($this->_debug != null) {
        $this->_smarty->assign('debug', $this->_debug);
      }
    }
    else {
      foreach ($this->_raw as $key => $value) {
        $this->_smarty->assign($key, $value);
      }
    }

    $this->_smarty->assign('asblock', $asBlock);

    if ($tplfile != '') {
      $this->__tplfile = $tplfile;
    }

    return $this->_smarty->fetch($this->__tplfile);
  }

  //=========================================================================
  /**
   * @param string $tpl
   */
  public function setTemplate($tpl) {
    $this->__tplfile = $tpl;
  }

  //=========================================================================
  /**
  * Wrapper for smarty's assign
  * @param string $name
  * @param string $data
  */
  public function assign($name, $data) {
    $this->_smarty->assign($name, $data);
  }
}
?>