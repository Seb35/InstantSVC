<?php
error_reporting(E_ALL);

class MyApp {
	
	private $classesList;
	private $methodsList;
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
	}
	
	private function collectWidgets() {
		$this->classesList = $this->glade->get_widget('classesList'); 
		$this->methodsList = $this->glade->get_widget('methodsList');
		$this->methodCodeTxt = $this->glade->get_widget('methodCodeTxt');
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
	
	public function clickBtn1() {
		echo 'btn clicked';
	}

	public function classSelected($selection) {
		//get_selected returns the store and the iterator for that row
	    list($classModel, $iter) = $selection->get_selected();
	    
	    $model = new GtkListStore(Gtk::TYPE_STRING, Gtk::TYPE_PHP_VALUE);
	    $className = $classModel->get_value($iter, 0);
	    
	    if (class_exists($className)) {
		    $class = new ReflectionClass($className);
		    $methods = $class->getMethods();
		
			foreach ($methods as $method) {
				$model->append(array($method->getName(), $method));	
			}
			$this->methodsList->set_model($model);
	    }
	}
	
	public function methodSelected($selection) {
		//get_selected returns the store and the iterator for that row
	    list($model, $iter) = $selection->get_selected();
	    
	    if (!is_null($iter)) {
	    	$method = $model->get_value($iter, 1);
	    	if ($method->isInternal()) {
	    		$code = 'Is internal Method, no code to display!';
	    	} else {
	    		$filename = $method->getDeclaringClass()->getFileName();
	    		$lines = file($filename);
	    		$start = $method->getStartLine();
	    		$end = $method->getEndLine();
	    		
	    		$code = '';
	    		foreach ($lines as $i => $line) {
	    			if ($i >= $start && $i < $end - 1) {
	    				$code .= $line;
	    			}
	    		}
	    	}
	    	
	    	$buffer = GtkSourceBuffer::new_with_language($this->sourceLang);
	    	$buffer->set_highlight(true);
	    	$buffer->set_text($code);
			
	    	$this->methodCodeTxt->set_buffer($buffer);
	    }
	}
}

$app = new MyApp();


//Start the main loop
Gtk::main();

echo ':: APP EXIT';
?>