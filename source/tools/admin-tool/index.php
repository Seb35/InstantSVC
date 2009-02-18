<?php
/**
 * AdminTool - MainClass
 *
 * Project: Web Services Description Generator
 *
 * @package    admintool
 * @author     Martin Sprengel <martin.sprengel@hpi.uni-potsdam.de>
 * @author     Stefan Marr <mail@stefan-marr.de>
 * @author     Falko Menge <mail@falko-menge.de>
 * @copyright  2006-2009 InstantSVC Team
 * @license    www.apache.org/licenses/LICENSE-2.0   Apache License 2.0
 * @lastchange 2005-11-26 Martin Sprengel
 *             2006-03-08 Stefan Marr
 *                         - Registrieren der Klassen fertiggestellt
 *                         - Speichern des published Flags der Methoden
 *                         - Wizard reaktiviert, neu implementiert
 *                         - Web Services erstellen implementiert
 *             See svn log for further changes
 */

error_reporting(E_ALL);


require_once(dirname(__FILE__).'/admin-tool-config.php');
require_once(dirname(__FILE__).'/admin-tool-lib.php');
require_once(dirname(__FILE__).'/admin-tool-smarty-connect.php');
require_once(dirname(__FILE__).'/admin-tool-db.php');

require_once(dirname(__FILE__).'/../../../libs/reflection/class.ExtReflectionClass.php');


/**
 * This class contains the main behaviour.
 *
 * @package    admintool
 * @author     Martin Sprengel <martin.sprengel@hpi.uni-potsdam.de>
 * @copyright  2006 ...
 * @license    http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */
class AdminToolApp {
    /**
     * attribute for Smarty
     * @var AdminToolSmartyConnect
     */
    protected $smarty = null;

    /**
     * @var AdminToolLibrary
     */
    protected $library = null;

    /**
     * @var AdminToolDB
     */
    protected $db = null;

    /**
     * @var string
     */
    protected $ws_output_folder = '';

    /**
     * @var Mime_Handler
     */
    protected static $mimeHandler;

    /**
     * Initialisierung
     * @return void
     */
    public function __construct() {

        // Neue Session starten
        session_start();

        // Variablen initialisieren
        // $this->smarty = new wsRenderEngine(null);
        $this->smarty  = new AdminToolSmartyConnect();
        $this->library = new AdminToolLibrary();
        $this->db      = new AdminToolDB();

        // TODO: Nicht auf DB durchgreifen, evtl. durch Lib kapseln
        if (!isset($_SESSION['searchpath'])) {
            if (!is_null($this->db->getProperty('searchpath'))) {
                $_SESSION['searchpath'] = $this->db->getProperty('searchpath');
            } else {
                $_SESSION['searchpath'] = STD_SEARCHPATH;
            }
        }

    }

    /**
     * dispatches the request
     * @return void
     */
    public function run() {

        $this->smarty->assign('title','InstantSVC Administration Tool');
        $this->smarty->assign('name','InstantSVC Administration Tool');
        $this->smarty->assign('action','');

        if (isset($_REQUEST['view'])) {
            switch ($_REQUEST['view']) {

                case 'build':
                    $this->handleBuild();
                    break;

                case 'wizard':
                    $this->handleWizard();
                    break;

                case 'register':
                    $this->handleRegister();
                    break;

                case 'config':
                    $this->handleConfig();
                    break;

                // Klassen sollen angezeigt werden
                case 'classes':
                    // Klassen anzeigen
                    $this->showClasses();
                    break;

                // Methoden sollen angezeigt werden ...
                case 'methods':

                    // ... Methoden welcher Klasse ...
                    if (isset($_REQUEST['class_id'])) {

                        // Eine Aktion auf den Methoden soll ausgeführt werden ...
                        if (isset($_REQUEST['methodView_action'])) {
                            switch ($_REQUEST['methodView_action']) {

                                // Veröffentlichungsstatus der Methoden speichern
                                case 'Speichern':

                                    // Selektierte Methoden speichern
                                    if (isset($_REQUEST['method_ids'])) {
                                        $this->db->setMethodsPublished($_REQUEST['class_id'], $_REQUEST['method_ids']);
                                    }
                                    // Keine Methode selektiert, also alle speichern
                                    else {
                                        $this->db->setMethodsPublished($_REQUEST['class_id'], array());
                                    }
                                    // dann wieder Methoden anzeigen
                                    $this->showMethods($_REQUEST['class_id']);
                                    break;

                                    // Sonst (Zurueck)
                                case 'Back':
                                    $this->showClasses();
                                    break;
                            }
                        } else {
                            // Methoden der Klasse anzeigen
                            $this->showMethods($_REQUEST['class_id']);
                        }
                    } else {
                        $this->showClasses();
                    }
                    break;

                    // Methoden Details anzeigen
                case 'method_detail':

                    // Details für gegebene Methode anzeigen
                    if (isset($_REQUEST['method_id'])) {

                        // Eine Aktion auf den Methoden soll ausgeführt werden ...
                        if (isset($_REQUEST['methodDetailsView_action'])) {
                            switch ($_REQUEST['methodDetailsView_action']) {

                                // Veröffentlichungsstatus der Methoden speichern
                                case 'Speichern':
                                    $this->db->insertUserComment($_REQUEST['method_id'], $_REQUEST['user_comment']);
                                    $this->showMethodDetail($_REQUEST['method_id']);
                                    break;

                                    // Sonst (Zurueck)
                                default:
                                    // $this->showMethods($_REQUEST['class_id']);
                                    $this->showMethods($_REQUEST['class_id']);
                            }
                        } else {
                            $this->showMethodDetail($_REQUEST['method_id']);
                        }
                    }
                    // Keine Methode gegeben, dann Methoden anzeigen
                    else {
                        $this->showMethods();
                    }
                    break;

                // Show method details 
                case 'wsreg':
                    $this->showWSRegistrationView();
                    break;

                case 'settings':
                    $this->handleSettings();
                    break;

                    // Sonst
                default:
                    $this->showIntro();
            }
        } else {
            $this->showIntro();
        }
    }


    /**
     * Zeigt den Startbildschirm an
     * @return void
     */
    protected function showIntro() {

        $this->smarty->display('admin-tool/admin-tool-intro.tpl');

    }

    protected function handleBuild() {
        if (!isset($_REQUEST['step'])) {
            $step = 0;
        } else {
            $step = (int)$_REQUEST['step'];
        }

        if (isset($_REQUEST['next'])) {
            $step++;
        } elseif (isset($_REQUEST['back'])) {
            $step--;
        }

        switch ($step) {
            // show registered classes and let the user select some
            case 0:
                $regClasses = $this->library->getRegisteredClasses();
                $this->smarty->assign('list_classes', $regClasses);
                $_SESSION['regClasses'] = $regClasses;
                break;

            // configure services
            case 1:
                if (isset($_REQUEST['class'])) {
                    $classes = array();
                    foreach ($_REQUEST['class'] as $id) {
                        $methods = $this->db->getMethodsByClass($id);
                        $_SESSION['regClasses'][$id]['methods'] = $methods;
                        $classes[$id] = $_SESSION['regClasses'][$id];
                    }
                    $_SESSION['classes2generate'] = $classes;
                    $this->smarty->assign('classes', $classes);
                    if (substr(INSTANTSVC_DEFAULT_SERVICE_URI, -1) == '/') {
                        $this->smarty->assign('serviceuri', INSTANTSVC_DEFAULT_SERVICE_URI);
                    } else {
                        $this->smarty->assign('serviceuri', INSTANTSVC_DEFAULT_SERVICE_URI . '/');
                    }
                    $this->smarty->assign('targetpath', realpath(INSTANTSVC_DEFAULT_TARGET_DIR));
                }
                break;

            // generate services
            case 2:
                if (!$this->checkTargetDir()) {

                    $this->smarty->assign('pathinvalid', true);
                    $this->smarty->assign('classes', $_SESSION['classes2generate']);
                    $step--;
                    break;
                } else {
                    $targetPath = $_REQUEST['targetpath'];
                }

                if (isset($_SESSION['classes2generate'])) {
                    $classes = $_SESSION['classes2generate'];
                    if (isset($_REQUEST['servicename'])) {
                        $services = array();
                        foreach ($_REQUEST['servicename'] as $id => $serviceName) {
                            $serviceName = stripslashes($serviceName);
                            if (isset($classes[$id])) {
                                $className = $classes[$id]['class_name'];
                                $_REQUEST['serviceuri'][$id] = stripslashes($_REQUEST['serviceuri'][$id]);
                                $_REQUEST['namespace'][$id] = stripslashes($_REQUEST['namespace'][$id]);

                                //create and write wsdl file
                                $saved = AdminToolLibrary::generateWsdl($className,
                                        $classes[$id]['class_file'],
                                        $serviceName,
                                        $_REQUEST['serviceuri'][$id],
                                        $_REQUEST['namespace'][$id],
                                        (int)$_REQUEST['wsdlstyle'][$id],
                                        $targetPath.'/'.$serviceName.'.wsdl');
                                if (!$saved) {
                                    $this->smarty->assign('generationfailed', true);
                                }


                                if ((int)$_REQUEST['wsdlstyle'][$id] == WSDLGenerator::DOCUMENT_WRAPPED) {
                                    $classfile = AdminToolLibrary::generateAdapter($className, $targetPath);
                                    $className = AdminToolLibrary::getAdapterClassName($className);
                                } else {
                                    $classfile = $classes[$id]['class_file'];
                                }

                                $service['wsdlfile']    = $serviceName.'.wsdl';
                                $service['servicename'] = $serviceName;
                                $service['utp']         = isset($_REQUEST['useutp'][$id]);
                                $service['classfile']   = $classfile;
                                $service['classname']   = $className;


                                $services[] = $service;
                            }
                        }

                        // assign data to display results
                        if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
                            $protocol = 'https://';
                        } else {
                            $protocol = 'http://';
                        }
                        $this->smarty->assign(
                            'wsdlurl',
                            $protocol . $_SERVER['HTTP_HOST']
                                . substr(
                                    realpath($targetPath),
                                    strlen(realpath($_SERVER['DOCUMENT_ROOT']))
                                )
                                .  '/'
                        );
                        $this->smarty->assign('generatedServices', $services);

                        //after all services are generated build deployment descriptor
                        AdminToolLibrary::generateDd($targetPath, $services);
                        AdminToolLibrary::generateServer($targetPath);
                    }
                }
                break;
        }
        $this->smarty->assign('step', $step);
        $this->smarty->display('admin-tool/admin-tool-wsgen-view.tpl');
    }

    protected function handleWizard() {
        $steps = array('start', 'step1', 'step2', 'finish', 'generate', 'cancel');
        if (isset($_SESSION['wizard']['step']) and in_array($_SESSION['wizard']['step'], $steps)) {
            $currentStep = $_SESSION['wizard']['step'];
        } else {
            $currentStep = 'start';
        }
        if (isset($_REQUEST['step']) and in_array($_REQUEST['step'], $steps)) {
            $nextStep = $_REQUEST['step'];
        } else {
            $nextStep = 'start';
        }
        if (isset($_REQUEST['next'])) {
            if ($currentStep == 'start') {
                $nextStep = 'step1';
            } elseif ($currentStep == 'step1') {
                $nextStep = 'step2';
            } elseif ($currentStep == 'step2') {
                $nextStep = 'finish';
            } elseif ($currentStep == 'finish') {
                $nextStep = 'generate';
            }
        } elseif (isset($_REQUEST['back'])) {
            if ($currentStep == 'step1') {
                $nextStep = 'start';
            } elseif ($currentStep == 'step2') {
                $nextStep = 'step1';
            } elseif ($currentStep == 'finish') {
                $nextStep = 'step2';
            } elseif ($currentStep == 'generate') {
                $nextStep = 'finish';
            }
        } elseif (isset($_REQUEST['cancel'])) {
            $nextStep = 'cancel';
        }
        $_SESSION['wizard']['step'] = $nextStep;

        switch ($_SESSION['wizard']['step']) {
            // select class path
            case 'step1':
                if (isset($_SESSION['searchpath'])) {
                    $this->smarty->assign('searchpath', realpath($_SESSION['searchpath']));
                } else {
                    $this->smarty->assign('searchpath', realpath(STD_SEARCHPATH));
                }
                break;

            // select classes
            case 'step2':
                if (isset($_REQUEST['searchpath'])) {
                    $_SESSION['searchpath'] = stripslashes($_REQUEST['searchpath']);
                    $result = $this->doSearch($_REQUEST['searchpath'], isset($_REQUEST['only_ws_tag']));
                    if ($result != null) {
                        $_SESSION['simpleClassList'] = $result;
                        $this->smarty->assign('list_classes', $result);
                        break;
                    } else {
                        $this->smarty->assign('pathfailed', true);
                    }
                } elseif (isset($_SESSION['simpleClassList'])) {
                    $this->smarty->assign('list_classes', $_SESSION['simpleClassList']);
                    break;
                }

                //else do step 1
                $_SESSION['wizard']['step'] = 'step1';
                //and do step1

            // configure services
            case 'finish':
                $classes = array();
                if (isset($_REQUEST['class'])) {
                    if (isset($_SESSION['classes'])) {
                        foreach ($_REQUEST['class'] as $class) {
                            if (isset($_SESSION['classes'][$class])) {
                                $classes[$class] = $_SESSION['classes'][$class];
                            }
                        }
                    }
                }
                $_SESSION['classes2generate'] = $classes;
                $this->smarty->assign('classes', $classes);
                    if (substr(INSTANTSVC_DEFAULT_SERVICE_URI, -1) == '/') {
                        $this->smarty->assign('serviceuri', INSTANTSVC_DEFAULT_SERVICE_URI);
                    } else {
                        $this->smarty->assign('serviceuri', INSTANTSVC_DEFAULT_SERVICE_URI . '/');
                    }
                $this->smarty->assign('targetpath', realpath(INSTANTSVC_DEFAULT_TARGET_DIR));
                break;

            // generate services
            case 'generate':
                if (!$this->checkTargetDir()) {

                    $this->smarty->assign('pathinvalid', true);
                    $this->smarty->assign('classes', $_SESSION['classes2generate']);
                    $_SESSION['wizard']['step'] = 'finish';
                    break;
                } else {
                    $targetPath = $_REQUEST['targetpath'];
                }

                if (isset($_SESSION['classes2generate'])) {
                    $classes = $_SESSION['classes2generate'];
                    if (isset($_REQUEST['servicename'])) {
                        $services = array();
                        foreach ($_REQUEST['servicename'] as $className => $serviceName) {
                            $serviceName = stripslashes($serviceName);
                            if (isset($classes[$className])) {
                                $origClassName = $className;
                                $_REQUEST['serviceuri'][$className] = stripslashes($_REQUEST['serviceuri'][$className]);
                                $_REQUEST['namespace'][$className] = stripslashes($_REQUEST['namespace'][$className]);

                                //create and write wsdl file
                                $saved = AdminToolLibrary::generateWsdl($className,
                                        $classes[$className]['file'],
                                        $serviceName,
                                        $_REQUEST['serviceuri'][$className],
                                        $_REQUEST['namespace'][$className],
                                        (int)$_REQUEST['wsdlstyle'][$className],
                                        $targetPath.'/'.$serviceName.'.wsdl');
                                if (!$saved) {
                                    $this->smarty->assign('generationfailed', true);
                                }


                                if ((int)$_REQUEST['wsdlstyle'][$className] == WSDLGenerator::DOCUMENT_WRAPPED) {
                                    $classfile = AdminToolLibrary::generateAdapter($className, $targetPath);
                                    $className = AdminToolLibrary::getAdapterClassName($className);
                                } else {
                                    $classfile = $classes[$className]['file'];
                                }

                                $service['wsdlfile']    = $serviceName.'.wsdl';
                                $service['servicename'] = $serviceName;
                                $service['utp']         = isset($_REQUEST['useutp'][$origClassName]);
                                $service['classfile']   = $classfile;
                                $service['classname']   = $className;


                                $services[] = $service;
                            }
                        }

                        // assign data to display results
                        if (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') {
                            $protocol = 'https://';
                        } else {
                            $protocol = 'http://';
                        }
                        $this->smarty->assign(
                            'wsdlurl',
                            $protocol . $_SERVER['HTTP_HOST']
                                . substr(
                                    realpath($targetPath),
                                    strlen(realpath($_SERVER['DOCUMENT_ROOT']))
                                )
                                .  '/'
                        );
                        $this->smarty->assign('generatedServices', $services);

                        //after all services are generated build deployment descriptor
                        AdminToolLibrary::generateDd($targetPath, $services);
                        AdminToolLibrary::generateServer($targetPath);
                    }
                }
                break;
        }
        $this->smarty->assign('step', $_SESSION['wizard']['step']);
        if ($_SESSION['wizard']['step'] == 'cancel') {
            $this->smarty->display('admin-tool/admin-tool-intro.tpl');
            unset($_SESSION['wizard']['step']);
        } else {
            $this->smarty->display('admin-tool/admin-tool-wizard.tpl');
        }
    }

    /**
     * Das Registrieren von Web Service Klassen behandeln
     * @return void
     */
    protected function handleRegister() {

        // Bei einer Aktion im Settings-View ...
        if (isset($_REQUEST['action'])) {
            if (isset($_SESSION['temp.searchpath'])) {
                $this->smarty->assign('searchpath', realpath(stripslashes($_SESSION['temp.searchpath'])));
            }
            switch ($_REQUEST['action']) {
                case 'Registrieren':
                    if (isset($_SESSION['classes']) and isset($_REQUEST['class'])) {
                        foreach ($_REQUEST['class'] as $name) {
                            if (isset($_SESSION['classes'][$name])) {
                                $class = $_SESSION['classes'][$name];
                                $refClass = null;
                                $id = $this->db->insertClass($name, $class['file']);

                                foreach ($class['methods'] as $mname => $method) {
                                    if ($method['webmethod']) {
                                        if ($refClass == null) {
                                            include_once($class['file']);
                                            if (class_exists($name))
                                                $refClass = new ReflectionClass($name);
                                        }

                                        $mId = $this->db->insertMethod($id, $mname);

                                        if ($refClass != null) {
                                            $refMethod = $refClass->getMethod($mname);
                                            $this->db->insertSourceCodeComment($mId, $refMethod->getDocComment());
                                        }
                                    }
                                }
                            }
                        }
                        $regClasses = $this->library->getRegisteredClasses();
                        $this->smarty->assign('tabledata',$regClasses);
                        $this->smarty->assign('subview','Registriert');
                        $this->smarty->assign('view','register');
                        $this->smarty->display('admin-tool/admin-tool-register-view.tpl');
                        break;
                    } else {
                        //Suchen ausführen
                    }

                case 'Suchen':
                    if (isset($_REQUEST['searchpath']))
                        $_SESSION['temp.searchpath'] = $_REQUEST['searchpath'];

                    $this->smarty->assign('view','register');
                    $this->smarty->assign('subview','Suchen');

                    $simpleClasses = $this->doSearch($_SESSION['temp.searchpath'], isset($_REQUEST['only_ws_tag']));



                    // TODO: Reflection Objekt hat Methodenzugriff / für Smarty aufbereiten
                    $this->smarty->assign('tabledata',$simpleClasses);

                    $this->smarty->display('admin-tool/admin-tool-register-view.tpl');

                    break;
                case 'Abbrechen':
                    // Alte Werte wiederherstellen ...
                    // $_SESSION['markedServer'] = $old_markedServer;
                    // $_SESSION['markedSecurity'] = $old_markedSecurity;
                    // Zurück zum Hauptmenü
                    $this->smarty->display('admin-tool/admin-tool-intro.tpl');
                    break;
                default:
                    // Bei anderen Aktionen mache nichts
            }
        } else {

            $this->smarty->assign('view','register');
            $this->smarty->assign('searchpath', realpath($_SESSION['searchpath']));
            $this->smarty->assign("only_ws_tag", true);

            $regClasses = $this->library->getRegisteredClasses();
            $this->smarty->assign('tabledata',$regClasses);

            $this->smarty->display('admin-tool/admin-tool-register-view.tpl');

        }

    }

    /**
     * Seach at the given path for classes
     * Registers $_SESSION['classes'] with complete class information
     * @param string $searchPath
     * @param string $onlyWithWebserviceTag
     * @return array<string,string>
     */
    protected function doSearch($searchPath, $onlyWithWebserviceTag) {
        $classes = $this->library->getAllClasses($searchPath);
        if ($classes == null) {
            return null;
        }

        $_SESSION['classes'] = $classes;
        $simpleClasses = array();
        foreach ($classes as $name => $class) {
            if (!$onlyWithWebserviceTag or $class['webservice']) {
                $simpleClasses[$name] = $class['file'];
            }
        }
        return $simpleClasses;
    }


    /**
     * Zeigt alle registrierten Klassen an
     * @return void
     */
    protected function showClasses() {

        // Registrierte Klassen bekommen ...
        $classes = $this->db->getClasses();

        // String zusammenbauen für Smarty-Template
        $index = 1;
        $class_list = array();
        foreach($classes as $key => $class) {
            $temp_string = "<b>" . $index . "</b> - " . $class["class_name"];
            if ($class["description"] != '') {
                $temp_string = $temp_string . " (" . $class["description"] . ")";
            }
            $class_list[$key] = $temp_string;
            $index++;
        }

        $this->smarty->assign('class_list', $class_list);
        $this->smarty->assign('view', 'methods');
        $this->smarty->display('admin-tool/admin-tool-classView.tpl');
    }

    /**
     * Zeigt alle Methoden einer Klasse an
     * @return void
     */
    protected function showMethods($class_id) {

        // Methoden einer Klassen bekommen ...
        $methods = $this->db->getMethodsByClass($class_id);
        $method_list_checked = array();
        $method_list = null;
        // String zusammenbauen für Smarty-Template
        $index = 1;
        foreach($methods as $key => $method) {
            $temp_string = "<b>" . $index . "</b> - " . $method["method_name"];
            if ($method["publish"] == true) {
                $temp_string = $temp_string . " (zur Zeit ver&ouml;ffentlicht)";
                $method_list_checked[] = $key;
            }
            if ($method["description"] != '') {
                $temp_string = $temp_string . " (" . $method["description"] . ")";
            }
            $method_list[$key] = "<a href=\"?view=method_detail&class_id=" . $class_id .
                "&method_id=" . $key . "\">" . $temp_string . "</a>";
            $index++;
        }

        $this->smarty->assign('method_list', $method_list);
        $this->smarty->assign('method_list_checked', $method_list_checked);
        $this->smarty->assign('view', 'methods');
        $this->smarty->assign('class_id', $class_id);
        $this->smarty->display('admin-tool/admin-tool-methodView.tpl');

    }


    /**
     * Speichert Methoden einer Klasse
     * @return void
     */
    protected function showMethodDetail($method_id) {

        $method = $this->db->getMethodByID($method_id);
        $source_code_comment = $this->db->getSourceCodeCommentByMethod($method_id);
        $user_comment = $this->db->getUserCommentByMethod($method_id);
        $class = $this->db->getClassByID($method["method_class_id"]);

        $this->smarty->assign('view', 'method_detail');
        $this->smarty->assign('method_id', $method_id);
        $this->smarty->assign('class_id', $method["method_class_id"]);
        $this->smarty->assign('method_name', $method["method_name"]);
        $this->smarty->assign('class_name', $class["class_name"]);
        $this->smarty->assign('source_code_comment', $source_code_comment["comment"]);
        $this->smarty->assign('user_comment', $user_comment["comment"]);

        $this->smarty->display('admin-tool/admin-tool-methodDetailsView.tpl');

    }


    /**
     * Speichert Methoden einer Klasse
     * @return void
     */
    protected function showWSRegistrationView() {
        $this->smarty->assign("classes_checked","");
        //$classes = $this->getAllClasses($this->db->getProperty("stats_root"));

        if (isset($_REQUEST["action"])) {
            switch ($_REQUEST["action"]) {
                case "Registrieren":
                    $selected_list = $_REQUEST["class_ids"];
                    foreach($classes as $key => $value) {
                        if (in_array($key, $selected_list)) {
                            $class = new ExtReflectionClass($value);
                            $methods = $class->getMethods();
                            $this->library->getPublishedMethods($methods);
                        }
                    }
                    break;
                case "Anwenden":
                    $this->db->setProperty("stats_root",$_REQUEST["root_path"]);
                    $classes = $this->library->getAllClasses($this->db->getProperty("stats_root"));
                    // Checkbox makieren oder nicht ...
                    if (isset($_REQUEST["only_ws_tag"])) {
                        $this->smarty->assign("only_ws_tag", true);
                        $classes = $this->library->filterWebServiceClasses($classes);
                    } else {
                        $this->smarty->assign("only_ws_tag", false);
                    }
                    break;
                default:

            }


        } else {
            // initial values
            $this->smarty->assign("only_ws_tag", true);
            $classes = $this->library->filterWebServiceClasses($classes);

        }

        $this->smarty->assign("only_ws_tag",$_REQUEST['only_ws_tag']);
        $this->smarty->assign('root_path',$this->db->getProperty("stats_root"));
        $this->smarty->assign('classes',$classes);
        $this->smarty->assign('view','wsreg');
        $this->smarty->display('admin-tool/admin-tool-wsgen-view.tpl');

    }


    /**
     * Anzeige der Einstellungen für das AdminTool und Behandlung der
     * Nutzereingaben bzgl. der Einstellungen
     * @return void
     */
    protected function handleSettings() {

        // Liste der gebotenen Server- und Sicherheitseinstellungen sowie Standardsuchpfad
        // für Web Service Klassen
        $serverList = array('soap' => 'SOAP-Server', 'rest' => 'REST-Server');
        $securityList = array('wss' => 'WS-Security (Username/Token-Profile)', 'none' => 'Keine');

        // Überprüfen, ob schon Einstellungen vorhanden sind
        if (!isset($_SESSION['markedServer'])) $_SESSION['markedServer'] = key($serverList);
        if (!isset($_SESSION['markedSecurity'])) $_SESSION['markedSecurity'] = key($securityList);
        if (!isset($_SESSION['searchpath'])) $_SESSION['searchpath'] = STD_SEARCHPATH;

        // Alte Werte für Wiederherstellung speichern
        // $old_markedServer = $_SESSION['markedServer'];
        // $old_markedSecurity = $_SESSION['markedSecurity'];

        // Bei einer Aktion im Settings-View ...
        if (isset($_REQUEST['action'])) {
            switch ($_REQUEST['action']) {
                case 'Ok':
                    // neue Werte in der Session speichern
                    if (array_key_exists($_REQUEST['selectedServer'], $serverList))
                        $_SESSION['markedServer'] = $_REQUEST['selectedServer'];
                    if (array_key_exists($_REQUEST['selectedSecurity'], $securityList))
                        $_SESSION['markedSecurity'] = $_REQUEST['selectedSecurity'];
                    $_SESSION['searchpath'] = $_REQUEST['searchpath'];
                    // Zurück zum Hauptmenü
                    $this->smarty->display('admin-tool/admin-tool-intro.tpl');
                    break;
                case 'Abbrechen':
                    // Alte Werte wiederherstellen ...
                    // $_SESSION['markedServer'] = $old_markedServer;
                    // $_SESSION['markedSecurity'] = $old_markedSecurity;
                    // Zurück zum Hauptmenü
                    $this->smarty->display('admin-tool/admin-tool-intro.tpl');
                    break;
                default:
                    // Bei anderen Aktionen mache nichts
            }
        } else {
            // Wenn keine Aktion ausgeführt wird, zeige Einstellungsdialog
            $this->smarty->assign('view', 'settings');
            $this->smarty->assign('searchpath', realpath($_SESSION['searchpath']));
            $this->smarty->assign('markedServer', $_SESSION['markedServer']);
            $this->smarty->assign('serverList', $serverList);
            $this->smarty->assign('markedSecurity', $_SESSION['markedSecurity']);
            $this->smarty->assign('securityList', $securityList);
            // Einstellungsdialog anzeigen
            $this->smarty->display('admin-tool/admin-tool-settings-view.tpl');
        }
    }

    /**
     * Überprüfung, ob der Ausgabeordner für SOAP-Server existiert
     * @return boolean
     */
    protected function checkTargetDir() {
        $returnValue = false;
        if (isset($_REQUEST['targetpath'])) {
            $dir = $_REQUEST['targetpath'];
            // check whether $dir is a subdirectory of the base dir
            if (
                strpos(
                    $dir,
                    realpath(INSTANTSVC_GENERATION_BASE_DIR)
                ) === 0
                and !preg_match('/[\\\\\/]\.\./', $dir)
            ) {
                if (
                    is_dir($dir)
                ) {
                    if (is_writable($dir)) {
                        $returnValue = true;
                    }
                } elseif (
                    !file_exists($dir)
                    and isset($_REQUEST['createTargetDirectory'])
                ) {
                    $returnValue = mkdir($dir, 0777, true);
                }
            }
        }
        return $returnValue;
    }

}

// Einstiegspunkt für das AdminTool
$app = new AdminToolApp();
$app->run();

?>
