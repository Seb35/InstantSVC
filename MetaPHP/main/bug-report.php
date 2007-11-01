<?php
error_reporting(E_ALL);

class iscReflectionMethod extends ReflectionMethod
{
    private $code = null;
    
	/**
    * @param mixed $class
    * @param string $name
    */
    public function __construct($class, $name) {
        parent::__construct($class, $name);
    }
    
    public function getCode() {
    	if ($this->code == null) {
    		if ($this->isInternal()) {
	    		$this->code = '/** Is internal Method, no code to display! **/';
	    	} else {
	    		$filename = $this->getDeclaringClass()->getFileName();
	    		$lines = file($filename);
	    		$start = $this->getStartLine();
	    		$end = $this->getEndLine();
	    		
	    		$code = '';
	    		foreach ($lines as $i => $line) {
	    			if ($i >= $start && $i < $end - 1) {
	    				$code .= $line;
	    			}
	    		}
	    		
	    		$this->code = $code;
	    	}
    	}
    	return $this->code;
    }
    
    public function setCode($code) {
    	if (function_exists('runkit_lint') && !runkit_lint($code)) {
    		throw new Exception('Code doesnt compile. Please correct error and try again.', 77);
    	}
    	$this->code = $code;
    	
    	$className = $this->getDeclaringClass()->getName();
    	$methodName = $this->getName();
    	$args = '';
    	$params = $this->getParameters();
    	foreach ($params as $param) {
    		if ($args == '') {
    			$args = '$'.$param->getName();
    		} else {
    			$args .= ', $'.$param->getName();
    		}
    	}
    
    	if ($this->isPrivate()) {
    		$flags = RUNKIT_ACC_PRIVATE;
    	} else if ($this->isProtected()) {
    		$flags = RUNKIT_ACC_PROTECTED;
    	} else if ($this->isPublic()) {
    		$flags = RUNKIT_ACC_PUBLIC;
    	}
    	    	
    	if (!runkit_method_redefine($className, $methodName, $args, $code , $flags)) {
    		throw new Exception('Code couldnt be set. May be this method is on the current call stack?.', 78);
    	}
    }
}

class MyApp {
	
	private $classesList;
	private $mainWindow;

	
	public function __construct() {
		$this->buildGui();
		$this->initClasses();
	}
	
	private function buildGui() {
		$this->mainWindow = new GtkWindow();
		$this->mainWindow->connect('destroy', 'shutdown');
		$this->mainWindow->set_border_width(10);
		
		$button = new GtkButton('Demonstrate Bug!');
		$button->connect('clicked', array($this, 'setMethodCode'));
		
		$this->classesList = new GtkTreeView(); 	
		
		$vbox = new GtkHBox();
		$vbox->pack_start($this->classesList);
		$vbox->pack_start($button);
		$this->mainWindow->add($vbox);		
		
		$this->mainWindow->show_all();
	}
	
	private function showCurrentClassList() {
		$model = new GtkListStore(Gtk::TYPE_STRING);
		$model->append(array('test'));		
		$this->classesList->set_model($model);
	}
	
	private function initClasses() {
		$this->showCurrentClassList();
		$renderer = new GtkCellRendererText();
		$column = new GtkTreeViewColumn("Class", $renderer, "text", 0);
		$this->classesList->append_column($column);
	}
	
	public function setMethodCode() {
		echo "enter setMethodCode\n";
	    
	    $code = "echo 'Test';"; 
	    	
	    $method = new iscReflectionMethod('Test', 'sayHello');
	    //runkit_method_redefine($method->getDeclaringClass()->getName(), 
    	//	$method->getName(), '', $code , RUNKIT_ACC_PUBLIC);
	    $method->setCode($code);
	    $this->showCurrentClassList();
	    $this->initMethods();
	}
}

class Test {
	public function sayHello() {
		echo 'Hello ';
	}
}


$app = new MyApp();

Gtk::main();

echo ':: APP EXIT';
?>
