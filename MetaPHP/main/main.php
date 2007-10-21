<?php
error_reporting(E_ALL);
require_once 'ezc/Base/base.php'; 

function __autoload($className) {        
	ezcBase::autoload($className);        
}

require_once(dirname(__FILE__) . '/../Reflection2/type_factory.php');

$factory = new iscReflectionTypeFactoryImpl();
ezcReflectionApi::setReflectionTypeFactory($factory);


class MyApp {
	
	private $classesList;
	private $methodsList;
	private $mainWindow;
	private $glade;
	private $methodCodeTxt;
	private $sourceLang;
	
	public function __construct() {
		$this->glade = new GladeXML(dirname(__FILE__) . '/../Glade/MetaPHP.glade');
		$this->glade->signal_autoconnect_instance($this);
		
		$this->collectWidgets();
		
		$this->initClasses();
		$this->initMethods();
		$this->initSourceView();
	}
	
	private function initSourceView() {
		$this->methodCodeTxt->set_show_line_numbers(true);
		$this->methodCodeTxt->set_show_line_markers(true);
		$this->methodCodeTxt->set_tabs_width(4);
		
		$lm = new GtkSourceLanguagesManager();
	    $this->sourceLang = $lm->get_language_from_mime_type('application/x-php');
	    
	    $buffer = GtkSourceBuffer::new_with_language($this->sourceLang);
    	$buffer->set_highlight(true);
    	$buffer->set_text('echo "\n\n";'."\n\n".
    		'$c = new iscReflectionClass(\'Test\');'."\n".
    		'$m = $c->getMethod(\'sayHello\');'."\n".
			'var_dump($m->getCode());'."\n".
    		'$m->setCode(\'echo "Test";\');'."\n".
    		'$t = new Test();'."\n".
    		'$t->sayHello();');
		
    	$this->methodCodeTxt->set_buffer($buffer);
	}
	
	private function collectWidgets() {
		$this->classesList = $this->glade->get_widget('classesList'); 
		$this->methodsList = $this->glade->get_widget('methodsList');
		$this->methodCodeTxt = $this->glade->get_widget('methodCodeTxt');
		$this->mainWindow = $this->glade->get_widget('MetaPHP');
	}
	
	private function initClasses() {
		$model = new GtkListStore(Gtk::TYPE_STRING);

		$classes = get_declared_classes();
		foreach ($classes as $class) {
			$model->append(array($class));	
		}
		
		$this->classesList->set_model($model);
		$renderer = new GtkCellRendererText();
		$column = new GtkTreeViewColumn("Class", $renderer, "text", 0);
		$this->classesList->append_column($column);
		
		$selection = $this->classesList->get_selection();
		$selection->connect("changed", array($this, "classSelected"));
	}
	
	private function initMethods() {
		$renderer = new GtkCellRendererText();
		$column = new GtkTreeViewColumn("Method", $renderer, "text", 0);
		$this->methodsList->append_column($column);
		
		$selection = $this->methodsList->get_selection();
		$selection->connect("changed", array($this, "methodSelected"));
	}
	
	public function execCode() {
		$buffer = $this->methodCodeTxt->get_buffer();
	    $code = $buffer->get_text($buffer->get_start_iter(), $buffer->get_end_iter());
	    eval($code);
	}
	
	public function setMethodCode() {
		$selection = $this->methodsList->get_selection();
		list($model, $iter) = $selection->get_selected();
	    
	    if (!is_null($iter)) {
	    	$method = $model->get_value($iter, 1);
	    	$buffer = $this->methodCodeTxt->get_buffer();
	    	$code = $buffer->get_text($buffer->get_start_iter(), $buffer->get_end_iter());
	    	
	    	
	    	try {
	    		$method->setCode($code);
	    	} catch (Exception $e) {
	    		$dialog = new GtkMessageDialog(
				    $this->mainWindow,//parent
				    0,
				    Gtk::MESSAGE_ERROR,
				    Gtk::BUTTONS_OK,
				    $e->getMessage()
				);
				/*$dialog->set_markup(
				    'Do <b>you</b> like PHP-Gtk '
				    . '<span foreground="red">2</span>?'
				);*/
				$answer = $dialog->run();
				$dialog->destroy();
	    	}
	    }
	}

	public function classSelected($selection) {
		//get_selected returns the store and the iterator for that row
	    list($classModel, $iter) = $selection->get_selected();
	    
	    if (!is_null($iter)) {
		    $model = new GtkListStore(Gtk::TYPE_STRING, Gtk::TYPE_PHP_VALUE);
		    $className = $classModel->get_value($iter, 0);
		    
		    if (class_exists($className)) {
			    $class = new iscReflectionClass($className);
			    $methods = $class->getMethods();
			
				foreach ($methods as $method) {
					$model->append(array($method->getName(), $method));	
				}
				$this->methodsList->set_model($model);
		    }
	    }
	}
	
	public function methodSelected($selection) {
		//get_selected returns the store and the iterator for that row
	    list($model, $iter) = $selection->get_selected();
	    
	    if (!is_null($iter)) {
	    	$method = $model->get_value($iter, 1);
	    	$code = $method->getCode();
	    	
	    	$buffer = GtkSourceBuffer::new_with_language($this->sourceLang);
	    	$buffer->set_highlight(true);
	    	$buffer->set_text($code);
			
	    	$this->methodCodeTxt->set_buffer($buffer);
	    }
	}
}

include('test.php');


$app = new MyApp();

$class = new iscReflectionClass('Test');
$class->getMethod('sayHello')->setCode('echo "Reflection::setCode Works :)";');

$test = new Test();
$test->sayHello();

//Start the main loop
Gtk::main();

echo ':: APP EXIT';
?>